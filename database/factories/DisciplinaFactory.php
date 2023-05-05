<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DisciplinaFactory extends customFactory
{
    public function definition()
    {
        dump('Starting Disciplina seeding');
        $disciplina = new DisciplinaFactory();

        $disciplina->insertTipoAvaliacao();
        $disciplina->insertSituacaoDisciplina();
        $disciplina->insertDisciplinas();
    }


    protected function insertTipoAvaliacao()
    {
        echo "    start insertTipoAvaliacao()". PHP_EOL;
        $datas = [
            ['nome'=>'Primeira Avaliação Semestral(P1)'],
            ['nome'=>'Segunda Avaliação Semestral(P2)'],
            ['nome'=>'Entrega de Trabalho'],
            ['nome'=>'Prova de Recuperação'],
        ];
        $this->verifyTable('tipos_de_avaliacoes', $datas);
    }


    protected function insertSituacaoDisciplina()
    {
        echo "    start insertSituacaoDisciplina()". PHP_EOL;
        $datas = [
            ['nome'=>'Aprovado'],
            ['nome'=>'Reprovado'],
            ['nome'=>'Matriculado'],
            ['nome'=>'Cancelado'],
            ['nome'=>'Em Andamento'],
            ['nome'=>'Trancado'],
            ['nome'=>'Dispensado'],
        ];

        $this->verifyTable('situacao_da_disciplina', $datas);
    }


    protected function insertDisciplinas()
    {
        echo "    start insertDisciplinas()". PHP_EOL;
        $disciplinas = [
            [
                "nome" => "Cálculo I", 
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Cálculo II", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Cálculo III", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Álgebra Linear", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geometria Analítica", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Equações Diferenciais Ordinárias", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Análise Real", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Análise Complexa", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Topologia", 
                "carga_horaria"=> 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Teoria dos Números", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Probabilidade", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Estatística", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Análise Numérica", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Métodos Matemáticos em Física", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Cálculo Variacional", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Matemática Financeira", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Matemática Discreta", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Modelagem Matemática", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Matemática Computacional", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História Antiga", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História Medieval", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História Moderna", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História Contemporânea", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da América Latina", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História do Brasil I", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História do Brasil II", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História do Brasil III", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História do Brasil IV", 
                "carga_horaria"=> 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da África", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Ásia", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Ciência", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Arte", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História do Cinema", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História do Direito", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Educação", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Filosofia", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Psicologia", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Religião", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História das Ideias Políticas", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História das Mulheres", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História Econômica", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História Social", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Linguística", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Gramática Normativa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sintaxe", 
                "carga_horaria"=> 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Morfologia", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Fonética e Fonologia", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Semântica", 
                "carga_horaria"=> 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Pragmática", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Redação e Expressão", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Oratória", 
                "carga_horaria"=> 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Literatura Brasileira", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Literatura Portuguesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Teoria da Literatura", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Literatura Brasileira", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Literatura Portuguesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Leitura e Produção Textual", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Revisão e Edição de Textos", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Gêneros Textuais", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Língua Portuguesa para Concursos", "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Linguagem e Tecnologia", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Língua Portuguesa como Segunda Língua", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Gramática da Língua Inglesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Vocabulário da Língua Inglesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Compreensão de Textos em Inglês", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Conversação em Inglês", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Redação em Inglês", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Literatura em Língua Inglesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Tradução em Língua Inglesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Cultura dos Países de Língua Inglesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Língua Inglesa para Negócios", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Língua Inglesa para Viagens", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Preparação para Exames de Proficiência em Língua Inglesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Língua Inglesa como Segunda Língua", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Linguagem e Tecnologia em Inglês", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Metodologia de Ensino de Língua Inglesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Fonética e Fonologia da Língua Inglesa", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sintaxe da Língua Inglesa",
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Leitura e Produção Textual em Inglês", 
                "carga_horaria" => 60,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Microbiologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Biologia Molecular", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Genética", 
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ecologia",
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Botânica", 
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Zoologia",
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Imunologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Biotecnologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Histologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Embriologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Biologia Celular", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Parasitologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Evolução", 
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Bioestatística", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Mecânica Clássica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Termodinâmica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Eletromagnetismo", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Óptica", 
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Física Moderna", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Física Nuclear", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Física de Partículas", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Astrofísica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Física Computacional", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Mecânica Quântica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Relatividade", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Física dos Materiais", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Física Experimental", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Física Teórica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Biofísica", 
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Física Médica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Física Ambiental", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Geral", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Orgânica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Inorgânica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Físico-Química", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Analítica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Ambiental", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Bioquímica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química dos Materiais", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Forense", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Industrial", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química de Alimentos", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Medicinal", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química de Polímeros", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Computacional", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Eletroquímica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Nuclear", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Química Quântica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Introdução à Filosofia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia Antiga", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia Medieval", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia Moderna", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia Contemporânea", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia da Ciência", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ética", 
                "carga_horaria" =>80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia Política", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia da Linguagem", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia da Mente", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia da Arte", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia da História", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Fenomenologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Hermenêutica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Epistemologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ontologia", 
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Física", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Humana", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Econômica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Cartografia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geoprocessamento", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Urbana", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Rural", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Política", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Cultural", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia do Brasil", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Geral", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Regional", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Geografia Ambiental", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História das Religiões", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Teologia", 
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Filosofia da Religião", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Mitos e Ritos", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Antropologia da Religião", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia da Religião", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia da Religião", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ética e Moral Religiosa", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Literatura Sagrada", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Interpretação da Bíblia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Comparação de Religiões", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ecumenismo e Diálogo Inter-religioso", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Introdução à Sociologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia Geral", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia do Trabalho", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia da Educação", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia Urbana", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia Rural", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia Política", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia da Cultura", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia da Comunicação",
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia das Relações de Gênero", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia das Desigualdades Sociais",
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sociologia Ambiental", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Introdução à Economia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Economia Política", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Microeconomia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Macroeconomia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Economia Brasileira", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Economia Internacional", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Economia do Setor Público",
                 "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Economia do Meio Ambiente",
                 "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Economia da Inovação", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Economia Monetária", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Economia do Trabalho", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Econometria", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Introdução à Psicologia", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia Geral", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia Social", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia do Desenvolvimento", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia da Personalidade", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia Clínica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia Educacional", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia Organizacional",
                 "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia da Saúde", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia da Comunicação",
                 "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia das Relações de Gênero", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia das Emoções", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Anatomia Humana", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Fisiologia Humana", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Educação Física", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Biomecânica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Teoria e Metodologia do Treinamento Desportivo",
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História da Educação Física e do Esporte",
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Atividades Físicas e Saúde", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Psicologia do Esporte", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Didática da Educação Física", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Lazer e Recreação", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Gestão em Esporte e Lazer",
                 "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Esporte Adaptado e Inclusão", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Metodologia da Pesquisa em Educação Física",
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Introdução à Programação", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Programação Orientada a Objetos", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Estrutura de Dados", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Banco de Dados", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Redes de Computadores", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Sistemas Operacionais", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Engenharia de Software", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Desenvolvimento Web", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Segurança da Informação", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Inteligência Artificial", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Computação Gráfica", 
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Robótica", 
                "carga_horaria"=> 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Metodologia da Pesquisa em Informática",
                "carga_horaria" => 80,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Linguagem e Literatura I", 
                "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Matemática I", 
                "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ciências I", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Artes Visuais I", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Música I", 
                "carga_horaria"=> 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Educação Física I", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História e Geografia I", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ensino Religioso I", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Linguagem e Literatura II",
                 "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Matemática II", 
                "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ciências II", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Artes Visuais II", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Música II",
                "carga_horaria"=> 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Educação Física II", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História e Geografia II", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ensino Religioso II", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Linguagem e Literatura III", 
                "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Matemática III", 
                "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ciências III", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Artes Visuais III", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Música III", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Educação Física III", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História e Geografia III", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ensino Religioso III", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Linguagem e Literatura IV",
                 "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Matemática IV", 
                "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ciências IV", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Artes Visuais IV", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Música IV",
                "carga_horaria"=> 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Educação Física IV", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História e Geografia IV", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ensino Religioso IV", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Linguagem e Literatura V", 
                "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Matemática V", 
                "carga_horaria" => 300,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ciências V", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Artes Visuais V", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Música V",
                "carga_horaria"=> 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Educação Física V", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "História e Geografia V", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
            [
                "nome" => "Ensino Religioso V", 
                "carga_horaria" => 200,
                'created_at'=>now(),
                'updated_at'=>now()],
        ];
        $this->verifyTable('disciplinas', $disciplinas);
    }


    


    
}
