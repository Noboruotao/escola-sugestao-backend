<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AreaConhecimento;

class AtividadeExtra extends Model
{
    use HasFactory;

    protected $table = 'atividade_extracurriculares';
    protected $fillable = [
        'nome',
        'tipo_id',
        'ativo'
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function ativExtraSugeridas()
    {
        return $this->morphToMany(Aluno::class, 'sugeridos');
    }


    public function alunos()
    {
        return $this->belongsToMany(
            Aluno::class,
            'aluno_ativExtra',
            'ativExtra_id',
            'aluno_id'
        )
            ->with('pessoa');
    }


    public function parametros()
    {
        return $this->morphMany(Parametro::class, 'model');
    }


    public function areas()
    {
        return $this->morphToMany(AreaConhecimento::class, 'model', 'model_has_areas', 'model_id', 'area_codigo');
    }

    public function tipo()
    {
        return $this->belongsTo(AtivExtraTipo::class);
    }


    public function getAtivExtras($page, $limit, $search, $sortColumn = 'nome', $order = 'asc', $tipo)
    {
        $query = self::orderBy($sortColumn, $order == '' ? 'asc' : $order)
            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', '%' . $search . '%');
            })
            ->when($tipo != '', function ($query) use ($tipo) {
                return $query->where('tipo_id', $tipo);
            })
            ->with('tipo');

        return [
            'count' => $query->count(),
            'data' => $query->offset($page * $limit)
                ->limit($limit)->get(),
        ];
    }


    public function getAtivExtraDetail($id)
    {
        $info =
            self::where('id', $id)
            ->with('tipo')
            ->when(!auth()->user()->hasRole('Aluno'), function ($query) {
                return $query->with('alunos');
            })
            ->first();


        if ($info == null) {
            return response()->json([
                'success' => false,
                'message' => 'Atividade Extracurricular Não Encontrado'
            ], 404);
        }
        return response()->json(['success' => true, 'data' => $info]);
    }


    public function attributeAtivExtraToAluno($aluno_id, $ativExtra_id)
    {
        $aluno = Aluno::find($aluno_id);
        $ativiExtra = self::find($ativExtra_id);

        if (!$aluno || !$ativiExtra) {
            return response()->json([
                'success' => false,
                'message' => 'Aluno ou Atividade Não Encontrada.'
            ], 404);
        }

        if ($aluno->attributeAtivExtra($ativiExtra)) {
            return response()->json([
                'success' => true,
                'data' => [
                    'aluno' => $aluno->pessoa->nome,
                    'ativExtra' => $ativiExtra->nome
                ]
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Error.'
        ], 400);
    }
}
