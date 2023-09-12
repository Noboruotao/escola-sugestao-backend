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

    public function multa()
    {
        return $this->morphOne(Multa::class, 'multas');
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

    public static function makeEmprestimo($bibliotecario_id, $acervo_id, $leitor_id)
    {
        $emprestimo = self::create([
            'acervo_id' => $acervo_id,
            'bibliotecario_id' => $bibliotecario_id,
            'leitor_id' => $leitor_id,
            'data_emprestimo' => Carbon::now()->format('Y-m-d'),
        ]);

        Acervo::find($acervo_id)->update(['situacao_id' => 2]);

        if ($aluno = Aluno::find($leitor_id)) {
            $aluno->AttributeAlunoAreaByAcervo(Acervo::find($acervo_id));
        }
        return $emprestimo;
    }


    public static function getEmprestimos($page = 0, $limit = null, $pendente = false)
    {
        $emprestimos = self::orderBy('data_emprestimo', 'desc')
            ->offset($page * $limit)
            ->limit($limit)
            ->when($pendente, function ($query) {
                return $query->whereNull('data_devolucao');
            })
            ->when(!auth()->user()->hasRole('Bibliotecário'), function ($query) {
                return $query->where('leitor_id', auth()->user()->id);
            })
            ->get();

        if ($pendente) {
            foreach ($emprestimos as $emprestimo) {
                self::makeMulta($emprestimo);
            }
        }

        return $emprestimos;
    }


    public static function makeDevolucao($emprestimo_id)
    {
        $emprestimo = self::find($emprestimo_id);
        $emprestimo->update(['data_devolucao' => Carbon::now()->format('Y-m-d')]);
        $emprestimo->acervo->update(['situacao_id' => 1]);

        self::makeMulta($emprestimo);

        return $emprestimo;
    }


    private static function valueForsearchMulta($emprestimo)
    {
        return [
            'pessoa_id' => $emprestimo->leitor_id,
            'multa_type' => self::class,
            'multa_id' => $emprestimo->id,
            'mensagem' => config('multa_mensagens.emprestimo_devolucao_atrasado'),
        ];
    }


    private static function valueForMultaDiasValor($daysInterval, $valorMulta)
    {
        return [
            'dias_atrasados' => $daysInterval,
            'valor' => $valorMulta,
        ];
    }


    public static function makeMulta(Emprestimo $emprestimo)
    {
        $data_devolucao = \Carbon\Carbon::parse($emprestimo->data_devolucao);
        $data_emprestimo = \Carbon\Carbon::parse($emprestimo->data_emprestimo);

        $daysInterval = $data_devolucao
            ? $data_devolucao->diffInDays($data_emprestimo)
            : now()->diffInDays($data_emprestimo);

        if ($daysInterval > 14) {
            $valorMulta = min($emprestimo->acervo->tipo->multa * $daysInterval, 100);

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
}
