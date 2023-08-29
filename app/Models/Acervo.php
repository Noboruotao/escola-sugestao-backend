<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Acervo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'subtitulo',
        'resumo',
        'tradutor',
        'autor_id',
        'idioma_id',
        'editora_id',
        'categoria_id',
        'tipo_id',
        'estado_id',
        'situacao_id',
        'IBNS',
        'ano_publicacao',
        'capa',
        'edicao',
        'data_aquisicao'
    ];


    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }


    public function idioma()
    {
        return $this->belongsTo(Idioma::class);
    }


    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }


    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }


    public function tipo()
    {
        return $this->belongsTo(AcervoTipo::class);
    }


    public function estado()
    {
        return $this->belongsTo(AcervoEstado::class);
    }


    public function situacao()
    {
        return $this->belongsTo(AcervoSituacao::class);
    }


    public function areas()
    {
        return $this->morphToMany(AreaConhecimento::class, 'model', 'model_has_areas', 'model_id', 'area_codigo');
    }


    public function materialSugerido()
    {
        return $this->belongsToMany(Disciplina::class, 'materiais_sugeridos');
    }


    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class, 'acervo_id', 'id');
    }


    public static function getAcervoList($page = 0, $limit = 10)
    {
        return Acervo::orderBy('titulo')
            ->offset($page * $limit)
            ->limit($limit)
            ->with(['emprestimos' => function ($query) {
                $query->whereNull('data_devolucao');
            }])
            ->get();
    }


    public static function makeEmprestimo($bibliotecario_id, $acervo_id, $leitor_id)
    {
        $emprestimo = Emprestimo::create([
            'acervo_id' => $acervo_id,
            'bibliotecario_id' => $bibliotecario_id,
            'leitor_id' => $leitor_id,
            'data_emprestimo' => Carbon::now()->format('Y-m-d'),
        ]);

        if ($aluno = Aluno::find($leitor_id)->first()) {
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
