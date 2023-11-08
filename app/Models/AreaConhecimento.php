<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Acervo;

class AreaConhecimento extends Model
{
    use HasFactory;

    protected $table = 'areas_de_conhecimentos';
    protected $primaryKey = 'codigo';
    protected $keyType = 'string';

    protected $fillable = [
        'codigo',
        'nome'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function alunos()
    {
        return $this->belongsToMany(
            Aluno::class,
            'aluno_areas_de_conhecimento',
            'area_codigo',
            'aluno_id',
            'codigo',
            'id'
        )
            ->using(AlunoAreasDeConhecimento::class)
            ->withPivot(
                'valor_notas',
                'valor_acervos',
                'valor_atividades',
                'valor_respondido'
            );
    }


    public function disciplinas()
    {
        return $this->morphedByMany(
            Acervo::class,
            'model',
            'model_has_areas',
            'area_codigo',
            'model_id'
        );
    }


    public function acervos()
    {
        return $this->morphedByMany(
            Acervo::class,
            'model',
            'model_has_areas',
            'area_codigo',
            'model_id'
        );
    }


    public function getAreas($degree)
    {
        $classes = self::where('codigo', 'like', '_')
            ->get();
        if ($degree > 1) {
            foreach ($classes as $classe) {

                $classe->sub_classes = $this->getSubClasses(
                    $classe,
                    $degree
                );
            }
        }
        return response()->json([
            'success' => true,
            'data' => $classes
        ]);
    }

    private function getSubClasses(
        $classe,
        $degree
    ) {
        $codigo = $classe->codigo;
        if (strlen($codigo) < $degree) {
            $sub_classes = self::where('codigo', 'like', $codigo . '_')
                ->orWhere('codigo', 'like', $codigo . '._')
                ->orWhere('codigo', 'like', $codigo . '_/%')
                ->get();


            foreach ($sub_classes as $sub_classe) {
                $results =  $this->getSubClasses(
                    $sub_classe,
                    $degree
                );
                if (strlen($results) > 0) {
                    $sub_classe->sub_classe = $results;
                }
            }
            return $sub_classes;
        }
    }


    public function getDescendantAreas()
    {
        $codigo = $this->codigo;
        $descendants = collect();

        do {
            $codigo = substr($codigo, 0, -1);
            $descendants = $descendants->merge(
                self::where('codigo', $codigo)
                    ->get()
            );
        } while ($codigo != '');

        return $descendants;
    }

    public function getAncestorAreas()
    {
        return self::where(
            'codigo',
            'like',
            '%/' . $this->codigo
        )
            ->orWhere(
                'codigo',
                'like',
                $this->codigo . '/%'
            )
            ->orWhere(
                'codigo',
                'like',
                $this->codigo . '%'
            )
            ->get();
    }

    public function getRelatedAreas()
    {
        return $this->getDescendantAreas()
            ->push($this)
            ->merge($this->getAncestorAreas())
            ->unique('codigo');
    }



    public function attributeAlunoEscolhas($escolhas)
    {
        $aluno = auth()->user()->aluno;
        if (!$aluno) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário Precisa ser Aluno.'
            ]);
        }

        $aluno->clearEscolhidos();
        $aluno->attribuirEscolhasValor($escolhas);

        return response()->json([
            'success' => true,
        ], 200);
    }
}
