<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Disciplina;
use App\Models\AtividadesExtracurriculares;
use App\Models\Acervo;

use App\Models\Curso;
use App\Models\AreasDeConhecimento;

class AreaDeConhecimentoFactory extends customFactory
{
    protected array $seederDatas;
    protected $faker;


    public function __construct()
    {
        $this->seederDatas = config('seeder_datas.areaConhecimentoSeederData');
        $this->faker = \Faker\Factory::create('pt_BR');
    }

    public function definition()
    {
        dump('Starting Area de Conhecimento seeding');
        $areas = new AreaDeConhecimentoFactory();

        // $areas->insertAreaConhecimento();
        // $areas->attributeAreasToDisciplina();
        // $areas->parametroAreasToCurso();

        // $areas->attributeAreasToAtivExtra();
        // $areas->parametroAreasAtivExtra();
        // $areas->attributeAreasToAcervo();

        // $areas->attributeDisciplinaToAno();
        $areas->insertMaterialSugerido();
    }


    protected function insertAreaConhecimento()
    {
        echo "    start insertAreaConhecimento()" . PHP_EOL;
        $this->verifyTable('areas_de_conhecimentos', $this->seederDatas['areas_de_conhecimento']);
    }


    protected function attributeAreasToDisciplina()
    {
        echo "    start attributeAreasToDisciplina()" . PHP_EOL;
        $areaDisciplina = $this->seederDatas['area_disciplina'];
        $areasDeConhecimento = AreasDeConhecimento::pluck('id', 'nome')->toArray();
        $disciplinas = Disciplina::pluck('id', 'nome')->toArray();

        $datas = [];

        foreach ($areaDisciplina as $relacao) {
            $disciplinaNome = $relacao['nome'];
            $disciplinaId = $disciplinas[$disciplinaNome];

            if (count($relacao['areas']) != 0) {
                foreach ($relacao['areas'] as $areasDeConhecimentoNome) {
                    $areasDeConhecimentoId = $areasDeConhecimento[$areasDeConhecimentoNome];

                    $datas[] = [
                        'areas_de_conhecimento_id' => $areasDeConhecimentoId,
                        'disciplina_id' => $disciplinaId
                    ];
                }
            }
        }
        $this->verifyTable('areas_de_conhecimento_disciplina', $datas);
    }


    protected function parametroAreasToCurso()
    {
        echo "    start parametroAreasToCurso()" . PHP_EOL;

        $cursos = $this->seederDatas['area_cursos'];
        $cursosInfo = Curso::whereIn('nome', array_column($cursos, 'nome'))->pluck('id', 'nome')->toArray();
        $areasDeConhecimento = AreasDeConhecimento::pluck('id', 'nome')->toArray();

        $datas = [];

        foreach ($cursos as $curso) {
            $cursoNome = $curso['nome'];
            $cursoId = $cursosInfo[$cursoNome];

            if (count($curso['areas']) != 0) {
                foreach ($curso['areas'] as $area) {
                    $areaNome = key($area);
                    $areaId = $areasDeConhecimento[$areaNome];

                    $datas[] = [
                        'curso_id' => $cursoId,
                        'areas_de_conhecimento_id' => $areaId,
                        'valor' => $area[$areaNome]
                    ];
                }
            }
        }
        $this->verifyTable('parametros_para_sugerir_curso', $datas);
    }


    protected function attributeAreasToAtivExtra()
    {
        echo "    start attributeAreasToAtivExtra()" . PHP_EOL;

        $atividades = $this->seederDatas['ativExtra_area'];
        $atividadesExtracurriculares = AtividadesExtracurriculares::pluck('id', 'nome')->toArray();
        $areasDeConhecimento = AreasDeConhecimento::pluck('id', 'nome')->toArray();

        $datas = [];

        foreach ($atividades as $atividade) {
            $atividadeNome = $atividade['nome'];
            $atividadeId = $atividadesExtracurriculares[$atividadeNome];

            foreach ($atividade['areas'] as $area) {
                $areaId = $areasDeConhecimento[$area];

                $datas[] = [
                    'areas_de_conhecimento_id' => $areaId,
                    'atividades_extracurriculares_id' => $atividadeId
                ];
            }
        }
        $this->verifyTable('areas_de_conhecimento_atividades_extracurricular', $datas);
    }


    protected function parametroAreasAtivExtra()
    {
        echo "    start parametroAreasAtivExtra()" . PHP_EOL;

        $atividades = $this->seederDatas['ativExtra_param'];
        $atividadesExtracurriculares = AtividadesExtracurriculares::pluck('id', 'nome')->toArray();
        $areasDeConhecimento = AreasDeConhecimento::pluck('id', 'nome')->toArray();

        $datas = [];

        foreach ($atividades as $atividade) {
            $atividadeNome = $atividade['nome'];
            $atividadeId = $atividadesExtracurriculares[$atividadeNome];

            foreach ($atividade['areas'] as $key => $value) {
                $areaId = $areasDeConhecimento[$key];

                $datas[] = [
                    'areas_de_conhecimento_id' => $areaId,
                    'atividades_extracurriculares_id' => $atividadeId,
                    'valor' => $value
                ];
            }
        }
        $this->verifyTable('parametro_para_sugerir_atividade_extracurricular', $datas);
    }


    protected function attributeAreasToAcervo()
    {
        echo "    start attributeAreasToAcervo()" . PHP_EOL;
        $areas = AreasDeConhecimento::pluck('id');
        Acervo::orderBy('id')->chunk(200, function (Collection $acervos) use ($areas) {
            foreach ($acervos as $acervo) {
                foreach ($areas->random($this->faker->numberBetween(1, 5)) as $area) {
                    $datas[] = [
                        'acervo_id' => $acervo->id,
                        'areas_de_conhecimento_id' => $area
                    ];
                }
            }
            $this->insertDatas('acervo_areas_de_conhecimento', $datas);
        });
    }


    protected function getDisciplinaPorArea($area)
    {
        $area_id = AreasDeConhecimento::where('nome', $area)->value('id');

        $disciplina_sem_ano = Disciplina::whereHas('areas', function ($query) use ($area_id) {
            $query->where('areas_de_conhecimento_id', $area_id);
        })
            ->whereDoesntHave('anos')
            ->inRandomOrder()
            ->value('id');

        if ($disciplina_sem_ano) {
            return $disciplina_sem_ano;
        }
    }


    protected function attributeDisciplinaToAno()
    {
        echo "    start attributeDisciplinaToAno()" . PHP_EOL;

        $anos = DB::table('anos')
            ->join('nivel_escolar', 'anos.nivel_escolar_id', '=', 'nivel_escolar.id')
            ->select('anos.id as id', 'nivel_escolar.nome as nivel_escolar', 'anos.ano')
            ->get();

        $levelData = [
            'Ensino Infantil' => [
                1 => ['Linguagem e Literatura I', 'Matemática I', 'Ciências I', 'Artes Visuais I', 'Música I', 'Educação Física I', 'História e Geografia I'],
                2 => ['Linguagem e Literatura II', 'Matemática II', 'Ciências II', 'Artes Visuais II', 'Música II', 'Educação Física II', 'História e Geografia II'],
                3 => ['Linguagem e Literatura III', 'Matemática III', 'Ciências III', 'Artes Visuais III', 'Música III', 'Educação Física III', 'História e Geografia III'],
                4 => ['Linguagem e Literatura IV', 'Matemática IV', 'Ciências IV', 'Artes Visuais IV', 'Música IV', 'Educação Física IV', 'História e Geografia IV'],
                5 => ['Linguagem e Literatura V', 'Matemática V', 'Ciências V', 'Artes Visuais V', 'Música V', 'Educação Física V', 'História e Geografia V']
            ],
            'Other' => ['Matemática', 'Ciências e Conhecimentos em Geral', 'Geografia', 'História']
        ];

        foreach ($anos as $ano) {
            if (isset($levelData[$ano->nivel_escolar]) && isset($levelData[$ano->nivel_escolar][$ano->ano])) {
                foreach ($levelData[$ano->nivel_escolar][$ano->ano] as $disciplina) {
                    $ano_disciplina[] = [
                        'ano_id' => $ano->id,
                        'disciplina_id' => Disciplina::where('nome', $disciplina)->first()->id,
                    ];
                }
            } else {
                foreach ($levelData['Other'] as $area) {
                    $ano_disciplina[] = [
                        'ano_id' => $ano->id,
                        'disciplina_id' => $this->getDisciplinaPorArea($area)
                    ];
                }
            }
            $this->insertDatas('ano_disciplina', $ano_disciplina);
            $ano_disciplina = [];
        }
    }


    protected function insertMaterialSugerido()
    {
        echo "    start insertMaterialSugerido()" . PHP_EOL;

        $acervos = Acervo::all();
        $disciplinas = Disciplina::all();

        $materialSugerido = [];

        Acervo::orderBy('id')->chunk(500, function (Collection $acervos) use ($disciplinas, $materialSugerido) {
            foreach ($acervos as $acervo) {
                $acervoAreas = $acervo->areas;
                foreach ($disciplinas as $disciplina) {
                    $intersect = $acervoAreas->intersect($disciplina->areas)->count();
                    if ($intersect > 0 && ($intersect >= 3 || $intersect == $disciplina->areas->count())) {
                        $materialSugerido[] = [
                            'disciplina_id' => $disciplina->id,
                            'acervo_id' => $acervo->id
                        ];
                        echo (count($materialSugerido));
                    }
                }
                if (count($materialSugerido) >= 200) {
                    $this->insertDatas('materiais_sugeridos', $materialSugerido);
                }
            }
        });

        if (!empty($materialSugerido)) {
            $this->insertDatas('materiais_sugeridos', $materialSugerido);
        }
    }
}
