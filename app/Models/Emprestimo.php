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
        return $this->hasOne(Acervo::class);
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
        $emprestimo = Emprestimo::create([
            'acervo_id' => $acervo_id,
            'bibliotecario_id' => $bibliotecario_id,
            'leitor_id' => $leitor_id,
            'data_emprestimo' => Carbon::now()->format('Y-m-d'),
        ]);

        if ($aluno = Aluno::find($leitor_id)) {
            $aluno->AttributeAlunoAreaByAcervo(Acervo::find($acervo_id));
        }
        return $emprestimo;
    }


    public static function getEmprestimos($page = 0, $limit = null, $pendente = false)
    {
        $emprestimos = Emprestimo::orderBy('data_emprestimo', 'desc')
            ->offset($page * $limit)
            ->limit($limit)
            ->when($pendente, function ($query) {
                return $query->whereNull('data_devolucao');
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
        $emprestimo = Emprestimo::find($emprestimo_id);
        $emprestimo->update(['data_devolucao' => Carbon::now()->format('Y-m-d')]);

        self::makeMulta($emprestimo);

        return $emprestimo;
    }


    private static function valueForsearchMulta($emprestimo)
    {
        return [
            'pessoa_id' => $emprestimo->leitor_id,
            'multa_type' => Emprestimo::class,
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
        $daysInterval = $emprestimo->data_devolucao
            ->diff($emprestimo->data_emprestimo)
            ->days;

        if ($daysInterval > 14) {
            $valorMulta = $emprestimo->acervo->tipo->multa * $daysInterval;
            if (!$multa = Multa::where(self::valueForsearchMulta($emprestimo))->first()) {
                $multa = Multa::create(self::valueForsearchMulta($emprestimo)->push(self::valueForMultaDiasValor($daysInterval, $valorMulta)));
            } else {
                $multa->update(self::valueForMultaDiasValor($daysInterval, $valorMulta));
            }
        }
    }
}
