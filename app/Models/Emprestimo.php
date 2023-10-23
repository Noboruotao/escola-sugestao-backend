<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'acervo_id',
        'bibliotecario_id',
        'leitor_id',
        'data_emprestimo',
        'data_devolucao'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function multa()
    {
        return $this->morphOne(Multa::class, 'multa');
    }


    public function acervo()
    {
        return $this->hasOne(Acervo::class, 'id', 'acervo_id');
    }


    public function bibliotecario()
    {
        return $this->hasOne(Pessoa::class, 'id', 'bibliotecario_id');
    }


    public function leitor()
    {
        return $this->hasOne(Pessoa::class, 'id', 'leitor_id');
    }

    public function makeEmprestimo($acervo_id, $leitor_id)
    {
        $bibliotecario_id = auth()->user()->id;
        $emprestimo = self::create([
            'acervo_id' => $acervo_id,
            'bibliotecario_id' => $bibliotecario_id,
            'leitor_id' => $leitor_id,
            'data_emprestimo' => Carbon::now()->format('Y-m-d'),
        ]);

        Acervo::find($acervo_id)->update(['situacao_id' => AcervoSituacao::EMPRESTADO]);

        if ($aluno = Aluno::find($leitor_id)) {
            $aluno->AttributeAlunoAreaByAcervo(Acervo::find($acervo_id));
        }
        return $emprestimo;
    }


    public function getEmprestimos(
        $page = 0,
        $limit = null,
        $search,
        $pendente = false
    ) {
        $query = self::select([
            'id',
            'data_emprestimo',
            'leitor_id',
            'acervo_id'
        ])
            ->orderByDesc('data_emprestimo')
            ->when($pendente, function ($query) {
                return $query->whereNull('data_devolucao');
            })
            ->when(!$pendente, function ($query) {
                return $query->whereNotNull('data_devolucao');
            })
            ->when(auth()->user()->hasRole('Bibliotecário') == false, function ($sub_query) {
                return $sub_query->where('leitor_id', auth()->user()->id);
            })
            ->where(function ($query) use ($search) {
                $query->whereHas('acervo', function ($sub_query) use ($search) {
                    $sub_query->where('titulo', 'like', "%$search%");
                })->orWhereHas('leitor', function ($sub_query) use ($search) {
                    $sub_query->where('nome', 'like', "%$search%");
                });
            });

        $count = $query->count();

        if ($count == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum Empréstimo Encontrado'
            ], 404);
        }

        $emprestimos = $query
            ->offset($page * $limit)
            ->limit($limit)
            ->get();

        if ($pendente) {
            foreach ($emprestimos as $emprestimo) {
                self::makeMulta($emprestimo);
            }
            $emprestimos->load('multa:multa_id,mensagem,valor');
        }
        $emprestimos->load('leitor:id,nome');
        $emprestimos->load('acervo:id,titulo');

        return response()->json([
            'success' => true,
            'data' => $emprestimos,
            'count' => $count
        ], 200);
    }


    public function getEmprestimoDetail($id)
    {
        $emprestimo = self::where('id', $id)
            ->with('acervo:id,titulo')
            ->with('leitor:id,nome')
            ->with('bibliotecario:id,nome')
            ->with('multa:id,multa_id,mensagem,valor')
            ->first();

        if ($emprestimo->exists()) {
            return response()->json(['succes' => true, 'data' => $emprestimo]);
        }
        return response()->json(['success' => false, 'message' => 'Emprestimo Não Encontrado.'], 404);
    }

    public function makeDevolucao($emprestimo_id)
    {
        $emprestimo = self::find($emprestimo_id);
        $emprestimo->update(['data_devolucao' => Carbon::now()->format('Y-m-d')]);
        $emprestimo->acervo->update(['situacao_id' => AcervoSituacao::DISPONIVEL]);

        self::makeMulta($emprestimo);

        return $emprestimo;
    }


    private function valueForsearchMulta($emprestimo)
    {
        return [
            'pessoa_id' => $emprestimo->leitor_id,
            'multa_type' => self::class,
            'multa_id' => $emprestimo->id,
            'mensagem' => config('multa_mensagens.emprestimo_devolucao_atrasado'),
        ];
    }


    private function valueForMultaDiasValor($daysInterval, $valorMulta)
    {
        return [
            'dias_atrasados' => $daysInterval,
            'valor' => $valorMulta,
        ];
    }


    public function makeMulta(Emprestimo $emprestimo)
    {
        $data_devolucao = Carbon::parse($emprestimo->data_devolucao);
        $data_emprestimo = Carbon::parse($emprestimo->data_emprestimo);

        $daysInterval = $data_devolucao
            ? $data_devolucao->diffInDays($data_emprestimo)
            : now()->diffInDays($data_emprestimo);

        if ($daysInterval > config('parametros.dias_de_emprestimo_de_acervo')) {
            $valorMulta = min($emprestimo->acervo->tipo->multa * $daysInterval, config('parametros.valor_maximo_da_multa_de_atraso_de_acervo'));

            $multaData = array_merge(
                self::valueForsearchMulta($emprestimo),
                self::valueForMultaDiasValor($daysInterval, $valorMulta)
            );

            Multa::updateOrCreate(
                self::valueForsearchMulta($emprestimo),
                $multaData
            );
        }
    }

    public function getUserEmprestimos()
    {
        $emprestimos = self::where('leitor_id', auth()->user()->id)
            ->with('acervo:id,titulo')
            ->orderBy('data_emprestimo')
            ->whereNull('data_devolucao')
            ->get();

        foreach ($emprestimos as $emprestimo) {
            $data_devolucao = Carbon::parse($emprestimo->data_emprestimo)
                ->addDays(config('parametros.dias_de_emprestimo_de_acervo'));
            $emprestimo->data_devolucao = $data_devolucao->format('d/m/Y');

            $emprestimo->color = ($data_devolucao->isBefore(Carbon::now())) ? 'red' : 'green';
        }

        if ($emprestimos->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Emprestimo Não Encontrado'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $emprestimos
        ]);
    }

    public function checkEmprestimosAtrasadosQnt()
    {
        return self::where('leitor_id', auth()->user()->id)
            ->whereNull('data_devolucao')
            ->whereDate('data_emprestimo', '<', Carbon::now()->subDays(14))
            ->count();
    }
}
