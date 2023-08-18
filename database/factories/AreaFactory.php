<?php

namespace Database\Factories;

use App\Models\Acervo;
use App\Models\AreaConhecimento;
use App\Models\AtividadeExtra;
use App\Models\Curso;
use App\Models\Disciplina;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
    }



    private static function generateMaterialSugerido($area, $disciplina_id)
    {
        $acervos = Acervo::where('titulo', $area->nome)->get();
        $materiais = [];
        foreach ($acervos as $acervo) {
            $materiais[] = [
                'disciplina_id' => $disciplina_id,
                'acervo_id' => $acervo->id,
            ];
        }
        DB::table('materiais_sugeridos')->insert($materiais);
    }


    private static function makeModelArea($codigo, $model_id, $model_type)
    {
        return [
            'area_codigo' => $codigo,
            'model_id' => $model_id,
            'model_type' => $model_type,
        ];
    }


    public static function attributeAreaDisciplina()
    {
        foreach (config('seeder_datas.areaDisciplina') as $disciplina_id => $disciplina_data) {
            $disciplina = Disciplina::find($disciplina_id);
            $areas = collect([]);
            foreach ($disciplina_data as $area_codigo) {
                $area = AreaConhecimento::where('codigo', $area_codigo)->first();

                self::generateMaterialSugerido($area, $disciplina_id);

                $relatedAreas = $area->getRelatedAreas();
                $areas = $areas->merge($relatedAreas)->unique('codigo');
            }

            $area_disciplina = [];
            foreach ($areas as $area) {
                // $disciplina->areas()->attach($area->codigo);
                $area_disciplina[] = self::makeModelArea($area->codigo, $disciplina->id, Disciplina::class);
            }
        }
        DB::table('model_has_areas')->insert($area_disciplina);
    }


    private static function makeParameter($codigo, $model_id, $model_type, $valor)
    {
        return [
            'area_codigo' => $codigo,
            'model_id' => $model_id,
            'model_type' => $model_type,
            'valor' => $valor,
        ];
    }


    public function generateCursoSugestao()
    {
        $parametros = [];
        foreach (config('seeder_datas.areaCurso') as $area_curso) {
            $curso = Curso::where('nome', $area_curso['nome'])->first();
            foreach ($area_curso['udc'] as $codigo => $valor) {
                $parametros[] = self::makeParameter($codigo, $curso->id, Curso::class, $valor);
            }
        }
        DB::table('parametros')->insert($parametros);
    }


    public function attributeAreaAtviExtra()
    {
        $parametros = [];
        foreach (config('seeder_datas.ativExtraArea') as $ativExtra_area) {
            $areas = collect();
            $ativExtra_areas = [];
            $ativExtra = AtividadeExtra::where('nome', $ativExtra_area['nome'])->first();
            foreach ($ativExtra_area['udc'] as $codigo => $valor) {

                $relatedAreas = AreaConhecimento::where('codigo', $codigo)->first()->getRelatedAreas();
                $areas = $areas->merge($relatedAreas)->unique('codigo');

                foreach ($areas as $area) {
                    $ativExtra_areas[] = self::makeModelArea(
                        $area->codigo,
                        $ativExtra->id,
                        AtividadeExtra::class
                    );
                }
                $parametros[] = self::makeParameter($codigo, $ativExtra->id, AtividadeExtra::class, $valor);
            }
            DB::table('model_has_areas')->insert($ativExtra_areas);
        }
        DB::table('parametros')->insert($parametros);
    }
}
