<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;


class AtividadeExtracurricularFactory extends customFactory
{
    public function definition()
    {
        dump('Starting Atividade Extracurricular seeding');
        $ativExtra = new AtividadeExtracurricularFactory();

        $ativExtra->insertTipoAtivExtra();
        $ativExtra->insertAtivExtra();
        $ativExtra->attributeAtivExtraToAluno();
    }


    protected function insertTipoAtivExtra()
    {
        echo "    start insertTipoAtivExtra()". PHP_EOL;
        $datas = [
            ["nome" => "Esportes"],
            ["nome" => "Artes"],
            ["nome" => "Voluntariado"],
            ["nome" => "Clube de Debate"],
            ["nome" => "Leitura"],
            ["nome" => "Empreendedorismo"],
            ["nome" => "Ciências"],
            ["nome" => "Matemática"],
            ["nome" => "História"],
            ["nome" => "Geografia"],
            ["nome" => "Religião"],
            ["nome" => "Filosofia"],
            ["nome" => "Sociologia"],
            ["nome" => "Psicologia"],
            ["nome" => "Informática"],
            ["nome" => "Robótica"],
            ["nome" => "Outros"]
        ];
        $this->insertDatas('tipos_de_atividade_extracurricular', $datas);
    }


    protected function insertAtivExtra()
    {
        echo "    start insertAtivExtra()". PHP_EOL;
        $atividades = [
            ['nome' => 'Futebol', 'tipo_id' => 1],
            ['nome' => 'Vôlei', 'tipo_id' => 1],
            ['nome' => 'Basquete', 'tipo_id' => 1],
            ['nome' => 'Handebol', 'tipo_id' => 1],
            ['nome' => 'Tênis de Mesa', 'tipo_id' => 1],
            ['nome' => 'Natação', 'tipo_id' => 1],
            ['nome' => 'Judô', 'tipo_id' => 1],
            ['nome' => 'Ginástica Rítmica', 'tipo_id' => 1],
            ['nome' => 'Atletismo', 'tipo_id' => 1],
            ['nome' => 'Badminton', 'tipo_id' => 1],
            ['nome' => 'Ginástica Artística', 'tipo_id' => 1],
            ['nome' => 'Remo', 'tipo_id' => 1],
            ['nome' => 'Boxe', 'tipo_id' => 1],
            ['nome' => 'MMA', 'tipo_id' => 1],
            ['nome' => 'Futsal', 'tipo_id' => 1],
            ['nome' => 'Surf', 'tipo_id' => 1],
            ['nome' => 'Skate', 'tipo_id' => 1],
            ['nome' => 'Ciclismo', 'tipo_id' => 1],
            ['nome' => 'Escalada', 'tipo_id' => 1],
            ['nome' => 'Esqui', 'tipo_id' => 1],
            ['nome' => 'Snowboard', 'tipo_id' => 1],
            ['nome' => 'Hóquei no Gelo', 'tipo_id' => 1],
            ['nome' => 'Rugby', 'tipo_id' => 1],
            ['nome' => 'Críquete', 'tipo_id' => 1],
            ['nome' => 'Golfe', 'tipo_id' => 1],
            ['nome' => 'Beisebol', 'tipo_id' => 1],
            ['nome' => 'Softbol', 'tipo_id' => 1],
            ['nome' => 'Pólo Aquático', 'tipo_id' => 1],
            ['nome' => 'Patinagem Artística', 'tipo_id' => 1],
            ['nome' => 'Patinagem de Velocidade', 'tipo_id' => 1],

            ['nome' => 'Teatro', 'tipo_id' => 2,],
            ['nome' => 'Música', 'tipo_id' => 2],
            ['nome' => 'Artes plásticas', 'tipo_id' => 2],
            ['nome' => 'Dança', 'tipo_id' => 2],
            ['nome' => 'Coral', 'tipo_id' => 2],
            ['nome' => 'Orquestra', 'tipo_id' => 2],
            ['nome' => 'Artes visuais', 'tipo_id' => 2],
            ['nome' => 'Balé', 'tipo_id' => 2],
            ['nome' => 'Pintura', 'tipo_id' => 2],

            ['nome' => 'Ações sociais em comunidades carentes', 'tipo_id' => 3],
            ['nome' => 'Campanhas de doação de sangue', 'tipo_id' => 3],
            ['nome' => 'Atividades em asilos e casas de repouso', 'tipo_id' => 3],
            ['nome' => 'Projetos de preservação ambiental', 'tipo_id' => 3],
            ['nome' => 'Atividades de Voluntariado em ONGs e Projetos Sociais', 'tipo_id' => 13],

            ['nome' => 'Clube de Debate', 'tipo_id' => 4],
            ['nome' => 'Model United Nations', 'tipo_id' => 4],

            ['nome' => 'Clube de Literatura', 'tipo_id' => 5],
            ['nome' => 'Clube do Livro', 'tipo_id' => 5],
            ['nome' => 'Oficina de Escrita Criativa', 'tipo_id' => 5],
            ['nome' => 'Sarau Literário', 'tipo_id' => 5],
            ['nome' => 'Concurso Literário', 'tipo_id' => 5],

            ['nome' => 'Empreendedorismo Social', 'tipo_id' => 6],
            ['nome' => 'Desenvolvimento de Projetos Empresariais','tipo_id' => 6],
            ['nome' => 'Participação em Competições de Empreendedorismo','tipo_id' => 6],
            ['nome' => 'Estudo de Casos Empresariais','tipo_id' => 6],
            ['nome' => 'Palestras sobre Empreendedorismo','tipo_id' => 6],
            ['nome' => 'Networking com Empreendedores','tipo_id' => 6],

            ['nome' => 'Clube de Ciências', 'tipo_id' => 7],
            ['nome' => 'Olimpíada de Ciências', 'tipo_id' => 7],
            ['nome' => 'Física Experimental', 'tipo_id' => 7],
            ['nome' => 'Astronomia', 'tipo_id' => 7],

            ['nome' => 'Olimpíada de Matemática', 'tipo_id' => 8],
            ['nome' => 'Clube de Matemática','tipo_id' => 8],
            ['nome' => 'Aulas de Reforço de Matemática','tipo_id' => 8],
            ['nome' => 'Jogos Matemáticos','tipo_id' => 8],
            ['nome' => 'Desafios Matemáticos','tipo_id' => 8],

            ['nome' => 'História em Debate', 'tipo_id' => 9],
            ['nome' => 'Clube de História','tipo_id' => 9],
            ['nome' => 'Simulações Históricas','tipo_id' => 9],
            ['nome' => 'Pesquisa de Campo','tipo_id' => 9],
            ['nome' => 'Visitas a Museus e Monumentos Históricos','tipo_id' => 9],
            ['nome' => 'Leitura de Livros de História','tipo_id' => 9],

            ['nome' => 'Geografia em Ação', 'tipo_id' => 10],
            ['nome' => 'Estudo de mapas e cartografia','tipo_id' => 10],
            ['nome' => 'Pesquisa sobre questões ambientais','tipo_id' => 10],
            ['nome' => 'Elaboração de projetos de turismo','tipo_id' => 10],
            ['nome' => 'Participação em simulações de conflitos geopolíticos','tipo_id' => 10],
            ['nome' => 'Organização de eventos culturais e folclóricos','tipo_id' => 10],

            ['nome' => 'Estudos de Religião', 'tipo_id' => 11,],

            ['nome' => 'Filosofia Contemporânea', 'tipo_id' => 12],
            ['nome' => 'Clube de Filosofia', 'tipo_id' => 12],
            ['nome' => 'Círculo de Discussão', 'tipo_id' => 12],
            ['nome' => 'Grupo de Estudos Filosóficos', 'tipo_id' => 12],
            ['nome' => 'Debates Filosóficos', 'tipo_id' => 12],
            ['nome' => 'Oficina de Filosofia', 'tipo_id' => 12],
            ['nome' => 'Seminários Filosóficos', 'tipo_id' => 12],
            ['nome' => 'Palestras Filosóficas', 'tipo_id' => 12],
            ['nome' => 'Conferências Filosóficas', 'tipo_id' => 12],

            ['nome' => 'Sociologia Urbana', 'tipo_id' => 13],
            ['nome' => 'Clube de Debates sobre Política', 'tipo_id' => 13],
            ['nome' => 'Grupo de Estudos sobre Desigualdades Sociais', 'tipo_id' => 13],
            ['nome' => 'Projeto de Intervenção Social em Comunidades Carentes', 'tipo_id' => 13],
            ['nome' => 'Seminários Temáticos sobre Teorias Sociológicas', 'tipo_id' => 13],
            ['nome' => 'Jornalismo Investigativo e Mídia Crítica', 'tipo_id' => 13],
            ['nome' => 'Observatório Social de Políticas Públicas', 'tipo_id' => 13],
            ['nome' => 'Grupo de Teatro para Debates Sociais', 'tipo_id' => 13],
            ['nome' => 'Organização de Debates sobre Movimentos Sociais', 'tipo_id' => 13],
            ['nome' => 'Clube de Cinema e Análise Fílmica', 'tipo_id' => 13],

            ['nome' => 'Psicologia Positiva', 'tipo_id' => 14],
            ['nome' => 'Grupo de estudos em psicologia cognitiva', 'tipo_id' => 14],
            ['nome' => 'Grupo de estudos em psicologia do desenvolvimento', 'tipo_id' => 14],
            ['nome' => 'Grupo de estudos em psicologia social', 'tipo_id' => 14],
            ['nome' => 'Grupo de estudos em psicologia clínica', 'tipo_id' => 14],
            ['nome' => 'Grupo de estudos em psicanálise', 'tipo_id' => 14],
            ['nome' => 'Grupo de discussão sobre saúde mental', 'tipo_id' => 14],
            ['nome' => 'Projeto de pesquisa em psicologia', 'tipo_id' => 14],
            ['nome' => 'Projeto de extensão em psicologia', 'tipo_id' => 14],
            ['nome' => 'Clube de debate sobre temas em psicologia', 'tipo_id' => 14],
            ['nome' => 'Oficina de orientação vocacional', 'tipo_id' => 14],
            ['nome' => 'Grupo de estudos em neuropsicologia', 'tipo_id' => 14],
            ['nome' => 'Grupo de estudos em psicologia organizacional', 'tipo_id' => 14],

            ["nome" => "Clube de programação", "tipo_id" => 15],
            ['nome' => 'Curso de desenvolvimento web', 'tipo_id' => 15],
            ['nome' => 'Curso de Programação em Python', 'tipo_id' => 15],
            ['nome' => 'Grupo de estudos de inteligência artificial', 'tipo_id' => 15],
            ['nome' => 'Curso de banco de dados', 'tipo_id' => 15],
            ['nome' => 'Grupo de estudos de Cibersegurança', 'tipo_id' => 15],
            ['nome' => 'Grupo de estudos de Análise de Dados', 'tipo_id' => 15],
            ['nome' => 'Olimpíada de Programação', 'tipo_id' => 15],
            ["nome" => "Oficina de jogos digitais", "tipo_id" => 15],
            
            ["nome" => "Clube de robótica", "tipo_id" => 16],
            ["nome" => "Oficina de programação de robôs", "tipo_id" => 16],
            ["nome" => "Campeonato de robótica", "tipo_id" => 16],
            ["nome" => "Curso de introdução à robótica", "tipo_id" => 16],
            ["nome" => "Desafio de robótica", "tipo_id" => 16],
            ["nome" => "Oficina de construção de robôs", "tipo_id" => 16],
            ["nome" => "Clube de robótica para iniciantes", "tipo_id" => 16],
            ["nome" => "Oficina de robótica para crianças", "tipo_id" => 16],
            ["nome" => "Projeto de robótica educacional", "tipo_id" => 16],

            ['nome' => 'Cinema', 'tipo_id' => 17],
            ['nome' => 'Jogos de tabuleiro', 'tipo_id' => 17],
            ['nome' => 'Artesanato', 'tipo_id' => 17],
            ['nome' => 'Fotografia', 'tipo_id' => 17],
            ['nome' => 'Atividades ao ar livre', 'tipo_id' => 17],
            ['nome' => 'Viagens e excursões', 'tipo_id' => 17],
              
        ];
        $this->insertDatas('atividade_extracurriculares', $atividades);
    }


    protected function attributeAtivExtraToAluno()
    {
        $alunos = \App\Models\Aluno::all();
        $datas = [];
        foreach($alunos as $aluno)
        {
            if($this->faker->randomDigit()<3)
            {
                $num_de_ativ = rand(1, 2);
                $atividade_extracurriculares = \App\Models\AtividadesExtracurriculares::limit($num_de_ativ)->inRandomOrder()->get();
                foreach($atividade_extracurriculares as $ativ_extra)
                {
                    $datas[] = [
                        'aluno_id'=> $aluno->id,
                        'atividades_extracurriculares_id'=>$ativ_extra->id,
                        'ativo'=> ($atividade_extracurriculares->last() === $ativ_extra)? 1: null
                    ];
                }
            }
        }
        $this->insertDatas('aluno_atividades_extracurriculares', $datas);
    }
}
