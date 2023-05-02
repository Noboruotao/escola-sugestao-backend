<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class AreaDeConhecimentoFactory extends customFactory
{
    public function definition()
    {
        $areas = new AreaDeConhecimentoFactory();

        $areas->insertAreaConhecimento();
        $areas->attributeAreasToAcervo();
        $areas->attributeDisciplinaToAno();

        
    }


    protected function insertAreaConhecimento()
    {
        $areas_de_conhecimento = [
            ['nome'=> 'Ciências e Conhecimentos em Geral'],
            ['nome'=> 'Documentação'],
            ['nome'=> 'Ciência e Tecnologia dos Computadores'],
            ['nome'=> 'Ciência de Dados/Análise de Dados'],
            ['nome'=> 'Inteligência Artificial'],
            ['nome'=> 'Bibliografias'],
            ['nome'=> 'Biblioteconomia'],
            ['nome'=> 'Filosofia'],
            ['nome'=> 'História da Filosofia'],
            ['nome'=> 'Psicologia'],
            ['nome'=> 'Lógica/Epstemologia'],
            ['nome'=> 'Moral/Ética'],
            ['nome'=> 'Metafísica'],
            ['nome'=> 'Religião'],
            ['nome'=> 'Parapsicologia e Ocultismo'],
            ['nome'=> 'Ciências Sociais'],
            ['nome'=> 'Estatisticas'],
            ['nome'=> 'Sociologia'],
            ['nome'=> 'Política'],
            ['nome'=> 'Economia'],
            ['nome'=> 'Direito/Jurisprudencia/Legislação'],
            ['nome'=> 'Administração Pública'],
            ['nome'=> 'Assistência Pública/Governo'],
            ['nome'=> 'Assuntos Militares'],
            ['nome'=> 'Asistência Social/Previdência Social/Seguros'],
            ['nome'=> 'Educação/Ensino/Pedagologia'],
            ['nome'=> 'Etnologia/Etnografia'],
            ['nome'=> 'Estudos de Gênero'],
            ['nome'=> 'Matemática'],
            ['nome'=> 'Astronomia'],
            ['nome'=> 'Geodesia'],
            ['nome'=> 'Cronologia'],
            ['nome'=> 'Física'],
            ['nome'=> 'Quimica'],
            ['nome'=> 'Cristalografia'],
            ['nome'=> 'Mineralogia'],
            ['nome'=> 'Ciências da Terra'],
            ['nome'=> 'Meteorogia/Climatologia'],
            ['nome'=> 'Estratigrafia'],
            ['nome'=> 'Petrologia'],
            ['nome'=> 'Geologia Econômica'],
            ['nome'=> 'Hidrologia'],
            ['nome'=> 'Paleontologia'],
            ['nome'=> 'Ciências Biólogicas'],
            ['nome'=> 'Antropologia'],
            ['nome'=> 'Biologia Geral'],
            ['nome'=> 'Ecologia'],
            ['nome'=> 'Genética'],
            ['nome'=> 'Citologia'],
            ['nome'=> 'Biotecnologia/Biofísica'],
            ['nome'=> 'Virologia'],
            ['nome'=> 'Microbiologia'],
            ['nome'=> 'Botânica'],
            ['nome'=> 'Zoologia'],
            ['nome'=> 'Biotecnologia'],
            ['nome'=> 'Medicina'],
            ['nome'=> 'Medicina Veterinária'],
            ['nome'=> 'Anatomia Humana'],
            ['nome'=> 'Engenharia'],
            ['nome'=> 'Engenharia Mecânica'],
            ['nome'=> 'Engenharia Eletrica'],
            ['nome'=> 'Eletrônica'],
            ['nome'=> 'Mineração'],
            ['nome'=> 'Engenharia Militar'],
            ['nome'=> 'Engenharia Civil'],
            ['nome'=> 'Engenharia Ferroviária'],
            ['nome'=> 'Engenharia Rodoviária'],
            ['nome'=> 'Engenharia Hidraulica'],
            ['nome'=> 'Engenharia de Saùde Pública'],
            ['nome'=> 'Ciência Agrária'],
            ['nome'=> 'Engenharia Florestal'],
            ['nome'=> 'Administração de Fazendas'],
            ['nome'=> 'Hortícultura'],
            ['nome'=> 'Criação de Animais'],
            ['nome'=> 'Caça e Pesca'],
            ['nome'=> 'Desenvolvimento Sustentável/Meio Ambiente'],
            ['nome'=> 'Culinária'],
            ['nome'=> 'Administração'],
            ['nome'=> 'Administração e Equipamentos do Lar'],
            ['nome'=> 'Administração de Escritório'],
            ['nome'=> 'Telecomunicação'],
            ['nome'=> 'Impressão/Publicação/Mercado Editorial'],
            ['nome'=> 'Contabilidade'],
            ['nome'=> 'Publicidade/Marketing/Relações Públicas'],
            ['nome'=> 'Comunicação/Jornalismo'],
            ['nome'=> 'Tecnologia Química'],
            ['nome'=> 'Metalurgia'],
            ['nome'=> 'Indústria e Artesanato'],
            ['nome'=> 'Construção'],
            ['nome'=> 'Planejamento Regional'],
            ['nome'=> 'Arquitetura'],
            ['nome'=> 'Artes Plásticas'],
            ['nome'=> 'Desenho'],
            ['nome'=> 'Pintura'],
            ['nome'=> 'Artes Gráficas'],
            ['nome'=> 'Fotografia'],
            ['nome'=> 'Música'],
            ['nome'=> 'Recreação/Entretenimento/Jogos'],
            ['nome'=> 'Cinema'],
            ['nome'=> 'Teatro'],
            ['nome'=> 'Dança'],
            ['nome'=> 'Jogos de Mesa e Tabuleiro'],
            ['nome'=> 'Esportes'],
            ['nome'=> 'Escultura/Cerâmica/Metalurgia'],
            ['nome'=> 'Linguística'],
            ['nome'=> 'Escolas Literárias'],
            ['nome'=> 'Críticas Literárias'],
            ['nome'=> 'Linguagem Inglesa'],
            ['nome'=> 'Arqueologia'],
            ['nome'=> 'Pré-Historia'],
            ['nome'=> 'Geografia'],
            ['nome'=> 'Genealogia'],
            ['nome'=> 'História'],
            ['nome'=> 'Teoria e filosofia da História'],
        ];
        $this->insertDatas('areas_de_conhecimentos', $areas_de_conhecimento);
        $this->attributeAreasToDisciplina();
        $this->parametroAreasToCurso();
        $this->attributeAreasToAtivExtra();
        $this->parametroAreasAtivExtra();
    }

    protected function attributeAreasToDisciplina()
    {
        $datas =[];

        $area_disciplina = [
            ["nome" => "Cálculo I", "areas" =>['Matemática', 'Estatisticas', 'Física']],
            ["nome" => "Cálculo II", "areas" =>['Matemática', 'Estatisticas', 'Física']],
            ["nome" => "Cálculo III", "areas" =>['Matemática', 'Estatisticas', 'Física']],
            ["nome" => "Álgebra Linear", "areas" =>['Matemática', 'Estatisticas', 'Física']],
            ["nome" => "Geometria Analítica", "areas" =>['Matemática', 'Física']],
            ["nome" => "Equações Diferenciais Ordinárias", "areas" =>['Matemática', 'Estatisticas', 'Física']],
            ["nome" => "Análise Real", "areas" =>['Matemática', 'Estatisticas', 'Física']],
            ["nome" => "Análise Complexa", "areas" =>['Matemática', 'Estatisticas', 'Física', 'Administração']],
            ["nome" => "Topologia", "areas" =>['Matemática', 'Estatisticas', 'Física', 'Geodesia']],
            ["nome" => "Teoria dos Números", "areas" =>['Matemática']],
            ["nome" => "Probabilidade", "areas" =>['Matemática', 'Estatisticas']],
            ["nome" => "Estatística", "areas" =>['Matemática', 'Estatisticas', 'Administração']],
            ["nome" => "Análise Numérica", "areas" =>['Matemática', 'Estatisticas']],
            ["nome" => "Métodos Matemáticos em Física", "areas" =>['Matemática', 'Física']],
            ["nome" => "Cálculo Variacional", "areas" =>['Matemática', 'Estatisticas', 'Física']],
            ["nome" => "Matemática Financeira", "areas" =>['Matemática', 'Estatisticas', 'Economia']],
            ["nome" => "Matemática Discreta", "areas" =>['Matemática', 'Estatisticas', 'Física']],
            ["nome" => "Modelagem Matemática", "areas" =>['Matemática', 'Estatisticas', 'Física']],
            ["nome" => "Matemática Computacional", "areas" =>['Matemática', 'Estatisticas', 'Ciência e Tecnologia dos Computadores']],
            ["nome" => "História Antiga", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História']],
            ["nome" => "História Medieval", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História']],
            ["nome" => "História Moderna", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História']],
            ["nome" => "História Contemporânea", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História']],
            ["nome" => "História da América Latina", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História', 'Geografia']],
            ["nome" => "História do Brasil I", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História', 'Geografia']],
            ["nome" => "História do Brasil II", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História', 'Geografia']],
            ["nome" => "História do Brasil III", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História', 'Geografia']],
            ["nome" => "História do Brasil IV", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História', 'Geografia']],
            ["nome" => "História da África", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História', 'Geografia']],
            ["nome" => "História da Ásia", "areas" =>['Sociologia', 'Política', 'Economia', 'Etnologia/Etnografia', 'História', 'Geografia']],
            ["nome" => "História da Ciência", "areas" =>['História', 'Ciências e Conhecimentos em Geral', 'Engenharia']],
            ["nome" => "História da Arte", "areas" =>['História', 'Artes Plásticas', 'Desenho', 'Pintura', 'Música', 'Artes Gráficas', 'Teatro', 'Dança', ]],
            ["nome" => "História do Cinema", "areas" =>['História', 'Cinema']],
            ["nome" => "História do Direito", "areas" =>['História', 'Política', 'Direito/Jurisprudencia/Legislação', 'Administração Pública']],
            ["nome" => "História da Educação", "areas" =>['História', 'Sociologia', 'Educação/Ensino/Pedagologia', 'Etnologia/Etnografia', 'Moral/Ética']],
            ["nome" => "História da Psicologia", "areas" =>['História', 'Psicologia']],
            ["nome" => "História da Religião", "areas" =>['História', 'Metafísica', 'Religião']],
            ["nome" => "História das Ideias Políticas", "areas" =>['História', 'Sociologia', 'Política', 'Direito/Jurisprudencia/Legislação', 'Administração Pública']],
            ["nome" => "História das Mulheres", "areas" =>['História', 'Estudos de Gênero', 'Moral/Ética', 'Sociologia']],
            ["nome" => "História Econômica", "areas" =>['História', 'Estatisticas', 'Economia']],
            ["nome" => "História Social", "areas" =>['História', 'Sociologia', 'Administração Pública', 'Ciências Sociais']],
            ["nome" => "Linguística", "areas" =>['Linguística']],
            ["nome" => "Gramática Normativa", "areas" =>['Linguística']],
            ["nome" => "Sintaxe", "areas" =>['Linguística']],
            ["nome" => "Morfologia", "areas" =>['Linguística']],
            ["nome" => "Fonética e Fonologia", "areas" =>['Linguística']],
            ["nome" => "Semântica", "areas" =>['Linguística']],
            ["nome" => "Pragmática", "areas" =>['Linguística']],
            ["nome" => "Redação e Expressão", "areas" =>['Linguística', 'Críticas Literárias', 'Comunicação/Jornalismo']],
            ["nome" => "Oratória", "areas" =>['Linguística', 'Comunicação/Jornalismo']],
            ["nome" => "Literatura Brasileira", "areas" =>['Linguística', 'Escolas Literárias']],
            ["nome" => "Literatura Portuguesa", "areas" =>['Linguística', 'Escolas Literárias']],
            ["nome" => "Teoria da Literatura", "areas" =>['Linguística', 'Escolas Literárias']],
            ["nome" => "História da Literatura Brasileira", "areas" =>['Linguística', 'Escolas Literárias', 'História']],
            ["nome" => "História da Literatura Portuguesa", "areas" =>['Linguística', 'Escolas Literárias', 'História']],
            ["nome" => "Leitura e Produção Textual", "areas" =>['Linguística', 'Críticas Literárias']],
            ["nome" => "Revisão e Edição de Textos", "areas" =>['Linguística', 'Críticas Literárias']],
            ["nome" => "Gêneros Textuais", "areas" =>['Linguística']],
            ["nome" => "Língua Portuguesa para Concursos", "areas" =>['Linguística', 'Escolas Literárias']],
            ["nome" => "Linguagem e Tecnologia", "areas" =>['Linguística']],
            ["nome" => "Língua Portuguesa como Segunda Língua", "areas" =>['Linguística']],
            ["nome" => "Gramática da Língua Inglesa", "areas" =>['Linguística', 'Linguagem Inglesa']],
            ["nome" => "Vocabulário da Língua Inglesa", "areas" =>['Linguística', 'Linguagem Inglesa']],
            ["nome" => "Compreensão de Textos em Inglês", "areas" =>['Linguística', 'Linguagem Inglesa', 'Críticas Literárias']],
            ["nome" => "Conversação em Inglês", "areas" =>['Linguística', 'Linguagem Inglesa']],
            ["nome" => "Redação em Inglês", "areas" =>['Linguística', 'Linguagem Inglesa', 'Críticas Literárias']],
            ["nome" => "Literatura em Língua Inglesa", "areas" =>['Linguística', 'Linguagem Inglesa', 'Escolas Literárias']],
            ["nome" => "Tradução em Língua Inglesa", "areas" =>['Linguística', 'Linguagem Inglesa']],
            ["nome" => "Cultura dos Países de Língua Inglesa", "areas" =>['Linguística', 'Linguagem Inglesa', 'Sociologia']],
            ["nome" => "Língua Inglesa para Negócios", "areas" =>['Linguística', 'Linguagem Inglesa', 'Publicidade/Marketing/Relações Públicas', 'Geografia']],
            ["nome" => "Língua Inglesa para Viagens", "areas" =>['Linguística', 'Linguagem Inglesa', 'Geografia']],
            ["nome" => "Preparação para Exames de Proficiência em Língua Inglesa", "areas" =>['Linguística', 'Linguagem Inglesa']],
            ["nome" => "Língua Inglesa como Segunda Língua", "areas" =>['Linguística', 'Linguagem Inglesa']],
            ["nome" => "Linguagem e Tecnologia em Inglês", "areas" =>['Linguística', 'Linguagem Inglesa']],
            ["nome" => "Metodologia de Ensino de Língua Inglesa", "areas" =>['Linguística', 'Linguagem Inglesa', 'Educação/Ensino/Pedagologia']],
            ["nome" => "Fonética e Fonologia da Língua Inglesa", "areas" =>['Linguística', 'Linguagem Inglesa']],
            ["nome" => "Sintaxe da Língua Inglesa", "areas" =>['Linguística', 'Linguagem Inglesa']],
            ["nome" => "Leitura e Produção Textual em Inglês", "areas" =>['Linguística', 'Linguagem Inglesa', 'Críticas Literárias']],
            ["nome" => "Microbiologia", "areas" =>['Microbiologia', 'Parapsicologia e Ocultismo','Ciências Biólogicas', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Biologia Molecular", "areas" =>['Microbiologia', 'Biologia Geral','Ciências Biólogicas', 'Citologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Genética", "areas" =>['Genética', 'Ciências Biólogicas', 'Citologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Ecologia", "areas" =>['Ciências Biólogicas', 'Desenvolvimento Sustentável/Meio Ambiente', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Botânica", "areas" =>['Ciências Biólogicas', 'Botânica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Zoologia", "areas" =>['Ciências Biólogicas', 'Zoologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Imunologia", "areas" =>['Ciências Biólogicas', 'Microbiologia', 'Virologia']],
            ["nome" => "Biotecnologia", "areas" =>['Ciências Biólogicas', 'Biotecnologia/Biofísica', 'Biotecnologia', 'Citologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Histologia", "areas" =>['Ciências Biólogicas', 'Citologia', 'Biotecnologia/Biofísica', 'Biotecnologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Embriologia", "areas" =>['Ciências Biólogicas', 'Educação/Ensino/Pedagologia', 'Medicina', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Biologia Celular", "areas" =>['Ciências Biólogicas', 'Citologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Parasitologia", "areas" =>['Ciências Biólogicas', 'Zoologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Evolução", "areas" =>['Ciências Biólogicas', 'Antropologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Bioestatística", "areas" =>['Ciências Biólogicas', 'Estatisticas', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Mecânica Clássica", "areas" =>['Física', 'Engenharia Mecânica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Termodinâmica", "areas" =>['Física', 'Engenharia Hidraulica', 'Quimica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Eletromagnetismo", "areas" =>['Física', 'Engenharia Eletrica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Óptica", "areas" =>['Física', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Física Moderna", "areas" =>['Física', 'Engenharia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Física Nuclear", "areas" =>['Física', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Física de Partículas", "areas" =>['Física', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Astrofísica", 'areas'=>['Física', 'Astronomia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Física Computacional", "areas" =>['Física', 'Ciência e Tecnologia dos Computadores', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Mecânica Quântica", "areas" =>['Física', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Relatividade", "areas" =>['Física', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Física dos Materiais", "areas" =>['Física', 'Quimica', 'Engenharia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Física Experimental", "areas" =>['Física', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Física Teórica", "areas" =>['Física', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Biofísica", "areas" =>['Física', 'Ciências Biólogicas', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Física Médica", "areas" =>['Física', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Física Ambiental", "areas" =>['Física', 'Ecologia', 'Desenvolvimento Sustentável/Meio Ambiente', 'Engenharia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Geral", "areas" =>['Quimica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Orgânica", "areas" =>['Quimica', 'Ciências Biólogicas', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Inorgânica", "areas" =>['Quimica', 'Ciências Biólogicas', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Físico-Química", "areas" =>['Quimica', 'Física', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Analítica", "areas" =>['Quimica', 'Estatisticas', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Ambiental", "areas" =>['Quimica', 'Desenvolvimento Sustentável/Meio Ambiente', 'Ecologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Bioquímica", "areas" =>['Quimica', 'Ciências Biólogicas', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química dos Materiais", "areas" =>['Quimica', 'Mineralogia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Forense", "areas" =>['Quimica', 'Ciências Biólogicas', 'Citologia', 'Medicina', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Industrial", "areas" =>['Quimica', 'Tecnologia Química', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química de Alimentos", "areas" =>['Quimica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Medicinal", "areas" =>['Quimica', 'Medicina', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química de Polímeros", "areas" =>['Quimica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Computacional", "areas" =>['Quimica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Eletroquímica", "areas" =>['Quimica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Nuclear", "areas" =>['Quimica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Química Quântica", "areas" =>['Quimica', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Introdução à Filosofia", "areas" =>['Filosofia', 'Teoria e filosofia da História']],
            ["nome" => "Filosofia da Ciência", "areas" =>['Filosofia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Ética", "areas" =>['Filosofia', 'Moral/Ética']],
            ["nome" => "Filosofia Política", "areas" =>['Filosofia', 'Política']],
            ["nome" => "Filosofia da Linguagem", "areas" =>['Filosofia', 'Linguística']],
            ["nome" => "Filosofia da Mente", "areas" =>['Filosofia', 'Psicologia']],
            ["nome" => "Filosofia da Arte", "areas" =>['Filosofia', 'Arquitetura', 'Desenho', 'Pintura', 'Artes Gráficas', 'Teatro', 'Escolas Literárias']],
            ["nome" => "Filosofia da História", "areas" =>['Filosofia', 'História', 'Teoria e filosofia da História']],
            ["nome" => "Fenomenologia", "areas" =>['Filosofia',]],
            ["nome" => "Hermenêutica", "areas" =>['Filosofia', 'Metafísica', 'Religião', 'Parapsicologia e Ocultismo']],
            ["nome" => "Epistemologia", "areas" =>['Filosofia', 'Moral/Ética']],
            ["nome" => "Ontologia", "areas" =>['Filosofia',]],
            ["nome" => "Geografia Física", "areas" =>['Geografia', 'Mineralogia', 'Petrologia', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "Geografia Humana", "areas" =>['Geografia', 'Geologia Econômica', 'Planejamento Regional', 'Ciências da Terra', 'Mineralogia']],
            ["nome" => "Geografia Econômica", "areas" =>['Geografia', 'Geologia Econômica','Planejamento Regional', 'Ciências Sociais', 'Economia']],
            ["nome" => "Cartografia", "areas" =>['Geografia', 'Geodesia']],
            ["nome" => "Geoprocessamento", "areas" =>['Geografia', 'Estatisticas', 'Documentação', 'Ciências da Terra', 'Planejamento Regional']],
            ["nome" => "Geografia Urbana", "areas" =>['Geografia', 'Geologia Econômica']],
            ["nome" => "Geografia Rural", "areas" =>['Geografia', 'Administração de Fazendas', 'Hortícultura', 'Criação de Animais']],
            ["nome" => "Geografia Política", "areas" =>['Geografia', 'Geologia Econômica', 'Política']],
            ["nome" => "Geografia Cultural", "areas" =>['Geografia', 'Etnologia/Etnografia']],
            ["nome" => "Geografia do Brasil", "areas" =>['Geografia', ]],
            ["nome" => "Geografia Geral", "areas" =>['Geografia', 'Engenharia']],
            ["nome" => "Geografia Regional", "areas" =>['Geografia', ]],
            ["nome" => "Geografia Ambiental", "areas" =>['Geografia', 'Desenvolvimento Sustentável/Meio Ambiente', 'Ciências e Conhecimentos em Geral']],
            ["nome" => "História das Religiões", "areas" =>['Religião', 'História', 'Geografia']],
            ["nome" => "Teologia", "areas" =>['Religião', 'Parapsicologia e Ocultismo', 'Metafísica']],
            ["nome" => "Filosofia da Religião", "areas" =>['Religião', 'Ciências Sociais']],
            ["nome" => "Mitos e Ritos", "areas" =>['Religião']],
            ["nome" => "Antropologia da Religião", "areas" =>['Religião']],
            ["nome" => "Sociologia da Religião", "areas" =>['Religião', 'Sociologia']],
            ["nome" => "Psicologia da Religião", "areas" =>['Religião', 'Psicologia']],
            ["nome" => "Ética e Moral Religiosa", "areas" =>['Religião', 'Moral/Ética']],
            ["nome" => "Literatura Sagrada", "areas" =>['Religião']],
            ["nome" => "Interpretação da Bíblia", "areas" =>['Religião']],
            ["nome" => "Comparação de Religiões", "areas" =>['Religião']],
            ["nome" => "Ecumenismo e Diálogo Inter-religioso", "areas" =>['Religião']],
            ["nome" => "Introdução à Sociologia", "areas" =>['Sociologia']],
            ["nome" => "Sociologia Geral", "areas" =>['Sociologia', 'Administração', 'Estatisticas', 'Geografia']],
            ["nome" => "Sociologia do Trabalho", "areas" =>['Sociologia']],
            ["nome" => "Sociologia da Educação", "areas" =>['Sociologia', 'Educação/Ensino/Pedagologia']],
            ["nome" => "Sociologia Urbana", "areas" =>['Sociologia', 'Geografia']],
            ["nome" => "Sociologia Rural", "areas" =>['Sociologia', 'Geografia', 'Geografia']],
            ["nome" => "Sociologia Política", "areas" =>['Sociologia', 'Geografia']],
            ["nome" => "Sociologia da Cultura", "areas" =>['Sociologia', 'Etnologia/Etnografia']],
            ["nome" => "Sociologia da Comunicação", "areas" =>['Sociologia', 'Comunicação/Jornalismo', 'Publicidade/Marketing/Relações Públicas']],
            ["nome" => "Sociologia das Relações de Gênero", "areas" =>['Sociologia', 'Estudos de Gênero']],
            ["nome" => "Sociologia das Desigualdades Sociais", "areas" =>['Sociologia', 'Etnologia/Etnografia', 'História']],
            ["nome" => "Sociologia Ambiental", "areas" =>['Sociologia', 'Desenvolvimento Sustentável/Meio Ambiente', 'Geografia']],
            ["nome" => "Introdução à Economia", "areas" =>[]],
            ["nome" => "Economia Política", "areas" =>['Economia', 'Estatisticas', 'Administração']],
            ["nome" => "Microeconomia", "areas" =>['Economia', 'Estatisticas', 'Geografia']],
            ["nome" => "Economia Brasileira", "areas" =>['Economia', 'Estatisticas']],
            ["nome" => "Economia Internacional", "areas" =>['Economia', 'Estatisticas']],
            ["nome" => "Economia do Setor Público", "areas" =>['Economia', 'Estatisticas', 'Assistência Pública/Governo', 'Asistência Social/Previdência Social/Seguros']],
            ["nome" => "Economia do Meio Ambiente", "areas" =>['Economia', 'Estatisticas', 'Desenvolvimento Sustentável/Meio Ambiente']],
            ["nome" => "Economia da Inovação", "areas" =>['Economia', 'Estatisticas']],
            ["nome" => "Economia Monetária", "areas" =>['Economia', 'Estatisticas']],
            ["nome" => "Economia do Trabalho", "areas" =>['Economia', 'Estatisticas']],
            ["nome" => "Econometria", "areas" =>['Economia', 'Estatisticas']],
            ["nome" => "Introdução à Psicologia", "areas" =>['Psicologia']],
            ["nome" => "Psicologia Geral", "areas" =>['Psicologia']],
            ["nome" => "Psicologia Social", "areas" =>['Psicologia']],
            ["nome" => "Psicologia do Desenvolvimento", "areas" =>['Psicologia']],
            ["nome" => "Psicologia da Personalidade", "areas" =>['Psicologia']],
            ["nome" => "Psicologia Clínica", "areas" =>['Psicologia']],
            ["nome" => "Psicologia Educacional", "areas" =>['Psicologia', 'Educação/Ensino/Pedagologia']],
            ["nome" => "Psicologia Organizacional", "areas" =>['Psicologia']],
            ["nome" => "Psicologia da Saúde", "areas" =>['Psicologia']],
            ["nome" => "Psicologia da Comunicação", "areas" =>['Psicologia', 'Comunicação/Jornalismo']],
            ["nome" => "Psicologia das Relações de Gênero", "areas" =>['Psicologia', 'Estudos de Gênero']],
            ["nome" => "Psicologia das Emoções", "areas" =>['Psicologia']],
            ["nome" => "Anatomia Humana", "areas" =>['Anatomia Humana', 'Antropologia']],
            ["nome" => "Fisiologia Humana", "areas" =>['Anatomia Humana', 'Antropologia']],
            ["nome" => "Educação Física", "areas" =>['Anatomia Humana', 'Antropologia', 'Educação/Ensino/Pedagologia']],
            ["nome" => "Biomecânica", "areas" =>['Anatomia Humana', 'Antropologia']],
            ["nome" => "Teoria e Metodologia do Treinamento Desportivo", "areas" =>['Anatomia Humana', 'Antropologia']],
            ["nome" => "História da Educação Física e do Esporte", "areas" =>['Anatomia Humana', 'Antropologia']],
            ["nome" => "História da Filosofia", 'areas'=> ['Filosofia', 'História da Filosofia', 'Sociologia', 'História']],
            ["nome" => "Atividades Físicas e Saúde", "areas" =>['Anatomia Humana', 'Antropologia']],
            ["nome" => "Psicologia do Esporte", "areas" =>['Anatomia Humana', 'Antropologia', 'Psicologia']],
            ["nome" => "Didática da Educação Física", "areas" =>['Anatomia Humana', 'Antropologia', 'Educação/Ensino/Pedagologia']],
            ["nome" => "Lazer e Recreação", "areas" =>['Anatomia Humana', 'Antropologia', 'Educação/Ensino/Pedagologia']],
            ["nome" => "Gestão em Esporte e Lazer", "areas" =>['Anatomia Humana', 'Antropologia', 'Educação/Ensino/Pedagologia']],
            ["nome" => "Esporte Adaptado e Inclusão", "areas" =>['Anatomia Humana', 'Antropologia'], 'Educação/Ensino/Pedagologia'],
            ["nome" => "Metodologia da Pesquisa em Educação Física", "areas" =>['Anatomia Humana', 'Antropologia', 'Educação/Ensino/Pedagologia']],
            ["nome" => "Introdução à Programação", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Programação Orientada a Objetos", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Estrutura de Dados", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Banco de Dados", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Redes de Computadores", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Sistemas Operacionais", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Engenharia de Software", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Desenvolvimento Web", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Segurança da Informação", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Inteligência Artificial", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia', 'Inteligência Artificial']],
            ["nome" => "Computação Gráfica", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Robótica", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia', 'Eletrônica', 'Engenharia']],
            ["nome" => "Metodologia da Pesquisa em Informática", "areas" =>['Ciências e Conhecimentos em Geral', 'Ciência e Tecnologia dos Computadores', 'Lógica/Epstemologia']],
            ["nome" => "Linguagem e Literatura I", "areas" =>[]],
            ["nome" => "Matemática I", "areas" =>[]],
            ["nome" => "Ciências I", "areas" =>[]],
            ["nome" => "Artes Visuais I", "areas" =>[]],
            ["nome" => "Música I", "areas" =>[]],
            ["nome" => "Educação Física I", "areas" =>[]],
            ["nome" => "História e Geografia I", "areas" =>[]],
            ["nome" => "Ensino Religioso I", "areas" =>[]],
            ["nome" => "Linguagem e Literatura II", "areas" =>[]],
            ["nome" => "Matemática II", "areas" =>[]],
            ["nome" => "Ciências II", "areas" =>[]],
            ["nome" => "Artes Visuais II", "areas" =>[]],
            ["nome" => "Música II", "areas" =>[]],
            ["nome" => "Educação Física II", "areas" =>[]],
            ["nome" => "História e Geografia II", "areas" =>[]],
            ["nome" => "Ensino Religioso II", "areas" =>[]],
            ["nome" => "Linguagem e Literatura III", "areas" =>[]],
            ["nome" => "Matemática III", "areas" =>[]],
            ["nome" => "Ciências III", "areas" =>[]],
            ["nome" => "Artes Visuais III", "areas" =>[]],
            ["nome" => "Música III", "areas" =>[]],
            ["nome" => "Educação Física III", "areas" =>[]],
            ["nome" => "História e Geografia III", "areas" =>[]],
            ["nome" => "Ensino Religioso III", "areas" =>[]],
            ["nome" => "Linguagem e Literatura IV", "areas" =>[]],
            ["nome" => "Matemática IV", "areas" =>[]],
            ["nome" => "Ciências IV", "areas" =>[]],
            ["nome" => "Artes Visuais IV", "areas" =>[]],
            ["nome" => "Música IV", "areas" =>[]],
            ["nome" => "Educação Física IV", "areas" =>[]],
            ["nome" => "História e Geografia IV", "areas" =>[]],
            ["nome" => "Ensino Religioso IV", "areas" =>[]],
            ["nome" => "Linguagem e Literatura V", "areas" =>[]],
            ["nome" => "Matemática V", "areas" =>[]],
            ["nome" => "Ciências V", "areas" =>[]],
            ["nome" => "Artes Visuais V", "areas" =>[]],
            ["nome" => "Música V", "areas" =>[]],
            ["nome" => "Educação Física V", "areas" =>[]],
            ["nome" => "História e Geografia V", "areas" =>[]],
            ["nome" => "Ensino Religioso V", "areas" =>[]],

        ];

        foreach($area_disciplina as $relacao)
        {
            $disciplina = \App\Models\Disciplina::where('nome', $relacao['nome'])->first();

            if( count($relacao['areas'])!=0 ){
                foreach($relacao['areas'] as $areas_de_conhecimento_nome)
                {
                    $datas[]=[
                        'areas_de_conhecimento_id'=> \App\Models\AreasDeConhecimento::where('nome', $areas_de_conhecimento_nome)->first()->id,
                        'disciplina_id' => $disciplina->id
                    ];
                }
            };
        }
        $this->insertDatas('areas_de_conhecimento_disciplina', $datas);


    
    }


    protected function parametroAreasToCurso()
    {
        $datas = [];
        $cursos = [
            [
                'nome' => 'Administração',
                'areas'=> [['Estatisticas'=> 7], ['Administração'=> 7]]
            ],
            [
                'nome' => 'Arquitetura e Urbanismo',
                'areas'=> [['Arquitetura'=>7], ['Engenharia'=>7], ['Geografia'=>7]]
            ],
            [
                'nome' => 'Biologia',
                'areas'=> [['Biologia Geral'=>8]]
            ],
            [
                'nome' => 'Ciências Contábeis',
                'areas'=> [['Economia'=> 8], ['Estatisticas'=>7] ]
            ],
            [
                'nome' => 'Direito',
                'areas'=> [['Direito/Jurisprudencia/Legislação'=>7]]
            ],
            [
                'nome' => 'Economia',
                'areas'=> [['Economia'=>7], ['Estatisticas'=>6]]
            ],
            [
                'nome' => 'Educação Física',
                'areas'=> [['Anatomia Humana'=>8]]
            ],
            [
                'nome' => 'Engenharia Civil',
                'areas'=> [['Engenharia'=>7], ['Geografia'=>6]]
            ],
            [
                'nome' => 'Engenharia de Computação',
                'areas'=> [['Ciência e Tecnologia dos Computadores'=> 7], ['Engenharia'=>6]]
            ],
            [
                'nome' => 'Engenharia Elétrica',
                'areas'=> [['Eletrônica'=>7], ['Engenharia'=>6]]
            ],
            [
                'nome' => 'Engenharia Mecânica',
                'areas'=> [['Engenharia'=>7], ['Física'=>7]]
            ],
            [
                'nome' => 'Enfermagem',
                'areas'=> [['Microbiologia'=>7], ['Ciências Biólogicas'=>7]]
            ],
            [
                'nome' => 'Farmácia',
                'areas'=> [['Quimica'=>7], ['Microbiologia'=>6]]
            ],
            [
                'nome' => 'Fisioterapia',
                'areas'=> [['Anatomia Humana'=>8]]
            ],
            [
                'nome' => 'Jornalismo',
                'areas'=> [['Comunicação/Jornalismo'=> 7], ['Críticas Literárias'=>6] ]
            ],
            [
                'nome' => 'Medicina',
                'areas'=> [['Medicina'=>8], ['Microbiologia'=>8]]
            ],
            [
                'nome' => 'Nutrição',
                'areas'=> [['Zoologia'=>7], ['Botânica'=>7]]
            ],
            [
                'nome' => 'Odontologia',
                'areas'=> [['Antropologia'=>7]]
            ],
            [
                'nome' => 'Psicologia',
                'areas'=> [['Psicologia'=>7]]
            ],
            [
                'nome' => 'Publicidade e Propaganda',
                'areas'=> [['Publicidade/Marketing/Relações Públicas'=>8]]
            ],
            [
                'nome' => 'Química',
                'areas'=> [['Quimica'=>8]]
            ],
            [
                'nome' => 'Relações Internacionais',
                'areas'=> [['Publicidade/Marketing/Relações Públicas'=>8], ['Etnologia/Etnografia'=>8] ]
            ],
            [
                'nome' => 'Serviço Social',
                'areas'=> [['Assistência Pública/Governo'=>7]]
            ],
            [
                'nome' => 'Veterinária',
                'areas'=> [['Zoologia'=>7]]
            ],
        ];

        foreach($cursos as $curso)
        {
            $curso_info = \App\Models\Curso::where('nome', $curso['nome'])->first();
            
            if( count($curso["areas"])!=0 )
            {
                foreach($curso["areas"] as $area)
                {
                    $datas[] = [
                        'curso_id'=> $curso_info->id,
                        'areas_de_conhecimento_id'=> \App\Models\AreasDeConhecimento::where('nome', key($area))->first()->id,
                        'valor'=>$area[key($area)]
                    ];
                }
            }
        }
        $this->insertDatas('parametros_para_sugerir_curso', $datas);
    }


    protected function attributeAreasToAtivExtra()
    {
        $datas = [];

        $atividades = [
            ['nome' => 'Futebol', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Vôlei', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Basquete', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Handebol', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Tênis de Mesa', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Natação', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Judô', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Ginástica Rítmica', 'areas'=>['Anatomia Humana', 'Música']],
            ['nome' => 'Atletismo', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Badminton', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Ginástica Artística', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Remo', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Boxe', 'areas'=>['Anatomia Humana']],
            ['nome' => 'MMA', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Futsal', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Surf', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Skate', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Ciclismo', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Escalada', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Esqui', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Snowboard', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Hóquei no Gelo', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Rugby', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Críquete', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Golfe', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Beisebol', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Softbol', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Pólo Aquático', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Patinagem Artística', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Patinagem de Velocidade', 'areas'=>['Anatomia Humana']],

            ['nome' => 'Teatro', 'areas'=>['Teatro']],
            ['nome' => 'Música', 'areas'=>['Música']],
            ['nome' => 'Artes plásticas', 'areas'=>['Artes Plásticas']],
            ['nome' => 'Dança', 'areas'=>['Dança']],
            ['nome' => 'Coral', 'areas'=>['Música']],
            ['nome' => 'Orquestra', 'areas'=>['Música']],
            ['nome' => 'Artes visuais', 'areas'=>['Artes Gráficas']],
            ['nome' => 'Balé', 'areas'=>['Dança']],
            ['nome' => 'Pintura', 'areas'=>['Pintura', 'Desenho']],

            ['nome' => 'Ações sociais em comunidades carentes', 'areas'=>['Asistência Social/Previdência Social/Seguros']],
            ['nome' => 'Atividades em asilos e casas de repouso', 'areas'=>['Anatomia Humana']],
            ['nome' => 'Projetos de preservação ambiental', 'areas'=>['Desenvolvimento Sustentável/Meio Ambiente', 'Ecologia']],
            ['nome' => 'Atividades de Voluntariado em ONGs e Projetos Sociais', 'areas'=>[]],

            ['nome' => 'Clube de Debate', 'areas'=>['Linguística', 'Críticas Literárias']],
            ['nome' => 'Model United Nations', 'areas'=>['Linguística', 'Críticas Literárias']],

            ['nome' => 'Clube de Literatura', 'areas'=>['Linguística', 'Escolas Literárias']],
            ['nome' => 'Clube do Livro', 'areas'=>['Linguística', 'Escolas Literárias']],
            ['nome' => 'Oficina de Escrita Criativa', 'areas'=>['Linguística', 'Críticas Literárias']],
            ['nome' => 'Sarau Literário', 'areas'=>['Linguística', 'Críticas Literárias']],
            ['nome' => 'Concurso Literário', 'areas'=>['Linguística', 'Críticas Literárias', 'Escolas Literárias']],

            ['nome' => 'Empreendedorismo Social', 'areas'=>['Economia', 'Administração']],
            ['nome' => 'Desenvolvimento de Projetos Empresariais','areas'=>['Economia', 'Administração', 'Administração de Escritório']],
            ['nome' => 'Participação em Competições de Empreendedorismo','areas'=>['Economia', 'Administração', 'Administração de Escritório']],
            ['nome' => 'Estudo de Casos Empresariais','areas'=>['Economia', 'Administração', 'Administração de Escritório', 'Administração e Equipamentos do Lar']],
            ['nome' => 'Palestras sobre Empreendedorismo','areas'=>['Economia', 'Administração', 'Publicidade/Marketing/Relações Públicas', 'Comunicação/Jornalismo']],
            ['nome' => 'Networking com Empreendedores','areas'=>['Economia', 'Administração', 'Ciência e Tecnologia dos Computadores']],

            ['nome' => 'Clube de Ciências', 'areas'=>['Ciências e Conhecimentos em Geral', 'Física', 'Quimica', 'Biologia Geral', 'Engenharia']],
            ['nome' => 'Olimpíada de Ciências', 'areas'=>['Ciências e Conhecimentos em Geral', 'Física', 'Quimica', 'Biologia Geral', 'Engenharia', 'Lógica/Epstemologia']],
            ['nome' => 'Física Experimental', 'areas'=>['Ciências e Conhecimentos em Geral', 'Física', 'Lógica/Epstemologia']],
            ['nome' => 'Astronomia', 'areas'=>['Ciências e Conhecimentos em Geral', 'Astronomia']],

            ['nome' => 'Olimpíada de Matemática', 'areas'=>['Matemática', 'Lógica/Epstemologia']],
            ['nome' => 'Clube de Matemática','areas'=>['Matemática', 'Lógica/Epstemologia']],
            ['nome' => 'Aulas de Reforço de Matemática','areas'=>['Matemática', 'Lógica/Epstemologia']],
            ['nome' => 'Jogos Matemáticos','areas'=>['Matemática', 'Lógica/Epstemologia', 'Recreação/Entretenimento/Jogos']],
            ['nome' => 'Desafios Matemáticos','areas'=>['Matemática', 'Lógica/Epstemologia']],

            ['nome' => 'História em Debate', 'areas'=>['História', 'Teoria e filosofia da História', 'Antropologia']],
            ['nome' => 'Clube de História','areas'=>['História', 'Teoria e filosofia da História', 'Antropologia']],
            ['nome' => 'Simulações Históricas','areas'=>['História', 'Teoria e filosofia da História', 'Antropologia']],
            ['nome' => 'Pesquisa de Campo','areas'=>['História', 'Teoria e filosofia da História', 'Antropologia']],
            ['nome' => 'Visitas a Museus e Monumentos Históricos','areas'=>['História', 'Arqueologia', 'Pré-Historia', 'Desenho', 'Pintura', 'Escultura/Cerâmica/Metalurgia', 'Antropologia']],
            ['nome' => 'Leitura de Livros de História','areas'=>['História', 'Escolas Literárias', 'Antropologia']],

            ['nome' => 'Geografia em Ação', 'areas'=>['Geografia']],
            ['nome' => 'Estudo de mapas e cartografia','areas'=>['Geografia', 'Geologia Econômica']],
            ['nome' => 'Pesquisa sobre questões ambientais','areas'=>['Geografia', 'Ciências da Terra', 'Desenvolvimento Sustentável/Meio Ambiente']],
            ['nome' => 'Elaboração de projetos de turismo','areas'=>['História', 'Arqueologia', 'Pré-Historia', 'Desenho', 'Pintura', 'Escultura/Cerâmica/Metalurgia', 'Antropologia']],
            ['nome' => 'Participação em simulações de conflitos geopolíticos','areas'=>['Geografia']],
            ['nome' => 'Organização de eventos culturais e folclóricos','areas'=>['História', 'Dança', 'Teatro', 'Antropologia', 'Música','Desenho', 'Pintura', ]],

            ['nome' => 'Estudos de Religião', 'areas'=>['Moral/Ética', 'Metafísica', 'Religião', 'Parapsicologia e Ocultismo']],

            ['nome' => 'Filosofia Contemporânea', 'areas'=>['Filosofia', 'História da Filosofia']],
            ['nome' => 'Clube de Filosofia', 'areas'=>['Filosofia', 'História da Filosofia']],
            ['nome' => 'Círculo de Discussão', 'areas'=>['Filosofia', 'História da Filosofia']],
            ['nome' => 'Grupo de Estudos Filosóficos', 'areas'=>['Filosofia', 'História da Filosofia']],
            ['nome' => 'Debates Filosóficos', 'areas'=>['Filosofia', 'História da Filosofia']],
            ['nome' => 'Oficina de Filosofia', 'areas'=>['Filosofia', 'História da Filosofia']],
            ['nome' => 'Seminários Filosóficos', 'areas'=>['Filosofia', 'História da Filosofia']],
            ['nome' => 'Palestras Filosóficas', 'areas'=>['Filosofia', 'História da Filosofia']],
            ['nome' => 'Conferências Filosóficas', 'areas'=>['Filosofia', 'História da Filosofia']],

            ['nome' => 'Sociologia Urbana', 'areas'=>['Sociologia', 'Direito/Jurisprudencia/Legislação']],
            ['nome' => 'Clube de Debates sobre Política', 'areas'=>['Sociologia', 'Direito/Jurisprudencia/Legislação']],
            ['nome' => 'Grupo de Estudos sobre Desigualdades Sociais', 'areas'=>['Sociologia', 'Direito/Jurisprudencia/Legislação', 'Asistência Social/Previdência Social/Seguros']],
            ['nome' => 'Projeto de Intervenção Social em Comunidades Carentes', 'areas'=>['Sociologia', 'Direito/Jurisprudencia/Legislação', 'Asistência Social/Previdência Social/Seguros']],
            ['nome' => 'Seminários Temáticos sobre Teorias Sociológicas', 'areas'=>['Sociologia']],
            ['nome' => 'Jornalismo Investigativo e Mídia Crítica', 'areas'=>['Sociologia', 'Comunicação/Jornalismo']],
            ['nome' => 'Observatório Social de Políticas Públicas', 'areas'=>['Sociologia', 'Direito/Jurisprudencia/Legislação', 'Política']],
            ['nome' => 'Grupo de Teatro para Debates Sociais', 'areas'=>['Sociologia', 'Teatro']],
            ['nome' => 'Organização de Debates sobre Movimentos Sociais', 'areas'=>['Sociologia', 'História']],
            ['nome' => 'Clube de Cinema e Análise Fílmica', 'areas'=>['Sociologia', 'Cinema']],

            ['nome' => 'Psicologia Positiva', 'areas'=>['Psicologia']],
            ['nome' => 'Grupo de estudos em psicologia cognitiva', 'areas'=>['Psicologia']],
            ['nome' => 'Grupo de estudos em psicologia do desenvolvimento', 'areas'=>['Psicologia']],
            ['nome' => 'Grupo de estudos em psicologia social', 'areas'=>['Psicologia']],
            ['nome' => 'Grupo de estudos em psicologia clínica', 'areas'=>['Psicologia']],
            ['nome' => 'Grupo de estudos em psicanálise', 'areas'=>['Psicologia']],
            ['nome' => 'Grupo de discussão sobre saúde mental', 'areas'=>['Psicologia']],
            ['nome' => 'Projeto de pesquisa em psicologia', 'areas'=>['Psicologia']],
            ['nome' => 'Projeto de extensão em psicologia', 'areas'=>['Psicologia']],
            ['nome' => 'Clube de debate sobre temas em psicologia', 'areas'=>['Psicologia']],
            ['nome' => 'Oficina de orientação vocacional', 'areas'=>['Psicologia']],
            ['nome' => 'Grupo de estudos em neuropsicologia', 'areas'=>['Psicologia']],
            ['nome' => 'Grupo de estudos em psicologia organizacional', 'areas'=>['Psicologia']],

            ["nome" => "Clube de programação", 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados']],
            ['nome' => 'Curso de desenvolvimento web', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados']],
            ['nome' => 'Curso de Programação em Python', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados', 'Inteligência Artificial']],
            ['nome' => 'Grupo de estudos de inteligência artificial', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados', 'Inteligência Artificial']],
            ['nome' => 'Curso de banco de dados', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados']],
            ['nome' => 'Grupo de estudos de Cibersegurança', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados']],
            ['nome' => 'Grupo de estudos de Análise de Dados', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados']],
            ['nome' => 'Olimpíada de Programação', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Inteligência Artificial']],
            ["nome" => "Oficina de jogos digitais", 'areas'=>['Ciência e Tecnologia dos Computadores', 'Inteligência Artificial', 'Recreação/Entretenimento/Jogos']],
            
            ['nome' => 'Clube de robótica', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados', 'Inteligência Artificial', 'Engenharia', 'Engenharia Mecânica', 'Engenharia Eletrica', 'Eletrônica']],
            ['nome' => 'Oficina de programação de robôs', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados', 'Inteligência Artificial', 'Engenharia', 'Engenharia Mecânica', 'Engenharia Eletrica', 'Eletrônica']],
            ['nome' => 'Campeonato de robótica', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados', 'Inteligência Artificial', 'Engenharia', 'Engenharia Mecânica', 'Engenharia Eletrica', 'Eletrônica', 'Recreação/Entretenimento/Jogos']],
            ['nome' => 'Curso de introdução à robótica', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados', 'Inteligência Artificial', 'Engenharia', 'Engenharia Mecânica', 'Engenharia Eletrica', 'Eletrônica']],
            ['nome' => 'Desafio de robótica', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados', 'Inteligência Artificial', 'Engenharia', 'Engenharia Mecânica', 'Engenharia Eletrica', 'Eletrônica']],
            ['nome' => 'Oficina de construção de robôs', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados', 'Inteligência Artificial', 'Engenharia', 'Engenharia Mecânica', 'Engenharia Eletrica', 'Eletrônica']],
            ['nome' => 'Clube de robótica para iniciantes', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Ciência de Dados/Análise de Dados', 'Inteligência Artificial', 'Engenharia', 'Engenharia Mecânica', 'Engenharia Eletrica', 'Eletrônica']],
            ['nome' => 'Oficina de robótica para crianças', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Inteligência Artificial', 'Engenharia', 'Recreação/Entretenimento/Jogos' ]],
            ['nome' => 'Projeto de robótica educacional', 'areas'=>['Ciência e Tecnologia dos Computadores', 'Engenharia', 'Recreação/Entretenimento/Jogos']],

            ['nome' => 'Cinema', 'areas'=>['Recreação/Entretenimento/Jogos', 'Cinema']],
            ['nome' => 'Jogos de tabuleiro', 'areas'=>['Recreação/Entretenimento/Jogos', 'Lógica/Epstemologia']],
            ['nome' => 'Artesanato', 'areas'=>['Recreação/Entretenimento/Jogos', 'Escultura/Cerâmica/Metalurgia']],
            ['nome' => 'Fotografia', 'areas'=>['Recreação/Entretenimento/Jogos', 'Fotografia']],
            ['nome' => 'Atividades ao ar livre', 'areas'=> ['Recreação/Entretenimento/Jogos']],
            ['nome' => 'Viagens e excursões', 'areas'=>['Recreação/Entretenimento/Jogos']],
              
        ];

        foreach($atividades as $atividade)
        {
        
            $ativ_extra = \App\Models\AtividadesExtracurriculares::where('nome', $atividade['nome'])->first();
            foreach($atividade['areas'] as $area)
            {
                $datas[] = [
                    'areas_de_conhecimento_id'=> \App\Models\AreasDeConhecimento::where('nome', $area)->first()->id,
                    'atividade_extracurricular_id'=>$ativ_extra->id
                ];
            }
        }
        $this->insertDatas('areas_de_conhecimento_atividades_extracurricular', $datas);
    }


    protected function parametroAreasAtivExtra()
    {
        $datas = [];

        $atividades = [
            ['nome' => 'Ginástica Rítmica', 'areas'=>['Anatomia Humana'=>8, 'Música'=>5]],
            ['nome' => 'Atletismo', 'areas'=>['Anatomia Humana'=>8]],
            ['nome' => 'Ginástica Artística', 'areas'=>['Anatomia Humana'=>8]],
            ['nome' => 'Escalada', 'areas'=>['Anatomia Humana'=>8]],
            ['nome' => 'Patinagem Artística', 'areas'=>['Anatomia Humana'=>8, 'Dança'=>5]],

            ['nome' => 'Teatro', 'areas'=>['Teatro'=>5]],
            ['nome' => 'Música', 'areas'=>['Música'=>5]],
            ['nome' => 'Artes plásticas', 'areas'=>['Artes Plásticas'=>5]],
            ['nome' => 'Dança', 'areas'=>['Dança'=>5]],
            ['nome' => 'Coral', 'areas'=>['Música'=>5]],
            ['nome' => 'Orquestra', 'areas'=>['Música'=>5]],
            ['nome' => 'Artes visuais', 'areas'=>['Artes Gráficas'=>5]],
            ['nome' => 'Balé', 'areas'=>['Dança'=>5]],
            ['nome' => 'Pintura', 'areas'=>['Pintura'=>3, 'Desenho'=>5]],

            ['nome' => 'Clube de Debate', 'areas'=>['Linguística'=>5, 'Críticas Literárias'=>8]],
            ['nome' => 'Model United Nations', 'areas'=>['Linguística'=>5, 'Críticas Literárias'=>8]],

            ['nome' => 'Clube de Literatura', 'areas'=>['Linguística'=>8, 'Escolas Literárias'=>8]],
            ['nome' => 'Clube do Livro', 'areas'=>['Linguística'=>5, 'Escolas Literárias'=>8]],
            ['nome' => 'Oficina de Escrita Criativa', 'areas'=>['Linguística'=>7, 'Críticas Literárias'=>8]],
            ['nome' => 'Sarau Literário', 'areas'=>['Linguística'=>8, 'Críticas Literárias'=>8]],
            ['nome' => 'Concurso Literário', 'areas'=>['Linguística'=>8, 'Críticas Literárias'=>8]],

            ['nome' => 'Empreendedorismo Social', 'areas'=>['Economia'=>8, 'Administração'=>6]],
            ['nome' => 'Desenvolvimento de Projetos Empresariais','areas'=>['Economia'=>7, 'Administração'=>7]],
            ['nome' => 'Participação em Competições de Empreendedorismo','areas'=>['Economia'=>8, 'Administração'=>7]],
            ['nome' => 'Estudo de Casos Empresariais','areas'=>['Economia'=>7, 'Administração'=>6]],
            ['nome' => 'Palestras sobre Empreendedorismo','areas'=>['Economia'=>6, 'Administração'=>6]],
            ['nome' => 'Networking com Empreendedores','areas'=>['Economia'=>8, 'Administração'=>8]],

            ['nome' => 'Clube de Ciências', 'areas'=>['Ciências e Conhecimentos em Geral'=>7]],
            ['nome' => 'Olimpíada de Ciências', 'areas'=>['Ciências e Conhecimentos em Geral'=>8]],
            ['nome' => 'Física Experimental', 'areas'=>['Física'=>7, 'Lógica/Epstemologia'=>6]],
            ['nome' => 'Astronomia', 'areas'=>['Astronomia'=>7]],

            ['nome' => 'Olimpíada de Matemática', 'areas'=>['Matemática'=>8]],
            ['nome' => 'Clube de Matemática','areas'=>['Matemática'=>6]],
            ['nome' => 'Jogos Matemáticos','areas'=>['Matemática'=> 6]],
            ['nome' => 'Desafios Matemáticos','areas'=>['Matemática'=> 6]],

            ['nome' => 'História em Debate', 'areas'=>['História'=> 7]],
            ['nome' => 'Clube de História','areas'=>['História'=> 7]],
            ['nome' => 'Simulações Históricas','areas'=>['História'=> 7, 'Teoria e filosofia da História'=> 7]],
            ['nome' => 'Pesquisa de Campo','areas'=>['História'=> 7, 'Antropologia'=> 7]],
            ['nome' => 'Visitas a Museus e Monumentos Históricos','areas'=>['História'=> 9]],
            ['nome' => 'Leitura de Livros de História','areas'=>['História'=> 7, 'Antropologia'=> 7]],

            ['nome' => 'Geografia em Ação', 'areas'=>['Geografia'=> 8]],
            ['nome' => 'Estudo de mapas e cartografia','areas'=>['Geografia'=> 7, 'Geologia Econômica'=> 6]],
            ['nome' => 'Pesquisa sobre questões ambientais','areas'=>['Geografia'=> 7, 'Desenvolvimento Sustentável/Meio Ambiente'=> 6]],
            ['nome' => 'Elaboração de projetos de turismo','areas'=>['História'=> 8]],
            ['nome' => 'Participação em simulações de conflitos geopolíticos','areas'=>['Geografia'=> 8]],
            ['nome' => 'Organização de eventos culturais e folclóricos','areas'=>['História'=> 9]],

            ['nome' => 'Estudos de Religião', 'areas'=>['Religião'=> 8]],

            ['nome' => 'Filosofia Contemporânea', 'areas'=>['Filosofia'=> 7, 'História da Filosofia'=> 7]],
            ['nome' => 'Clube de Filosofia', 'areas'=>['Filosofia'=> 7]],
            ['nome' => 'Círculo de Discussão', 'areas'=>['Filosofia'=> 8]],
            ['nome' => 'Grupo de Estudos Filosóficos', 'areas'=>['Filosofia'=> 7]],
            ['nome' => 'Debates Filosóficos', 'areas'=>['Filosofia'=> 7]],
            ['nome' => 'Oficina de Filosofia', 'areas'=>['Filosofia'=> 7]],
            ['nome' => 'Seminários Filosóficos', 'areas'=>['Filosofia'=> 7, 'História da Filosofia'=> 7]],
            ['nome' => 'Palestras Filosóficas', 'areas'=>['Filosofia'=> 6]],
            ['nome' => 'Conferências Filosóficas', 'areas'=>['Filosofia'=> 8, 'História da Filosofia'=> 8]],

            ['nome' => 'Sociologia Urbana', 'areas'=>['Sociologia'=> 8, 'Direito/Jurisprudencia/Legislação'=> 8]],
            ['nome' => 'Clube de Debates sobre Política', 'areas'=>['Sociologia'=> 8, 'Direito/Jurisprudencia/Legislação'=> 8]],
            ['nome' => 'Grupo de Estudos sobre Desigualdades Sociais', 'areas'=>['Sociologia'=> 5, 'Direito/Jurisprudencia/Legislação'=> 6, 'Asistência Social/Previdência Social/Seguros'=> 5]],
            ['nome' => 'Projeto de Intervenção Social em Comunidades Carentes', 'areas'=>['Asistência Social/Previdência Social/Seguros'=> 8]],
            ['nome' => 'Seminários Temáticos sobre Teorias Sociológicas', 'areas'=>['Sociologia'=> 8]],
            ['nome' => 'Jornalismo Investigativo e Mídia Crítica', 'areas'=>['Sociologia'=> 6, 'Comunicação/Jornalismo'=> 8]],
            ['nome' => 'Observatório Social de Políticas Públicas', 'areas'=>['Sociologia'=> 7, 'Direito/Jurisprudencia/Legislação'=> 6, 'Política'=> 7]],
            ['nome' => 'Grupo de Teatro para Debates Sociais', 'areas'=>['Sociologia'=> 7, 'Teatro'=> 5]],
            ['nome' => 'Organização de Debates sobre Movimentos Sociais', 'areas'=>['Sociologia'=> 6, 'História'=> 8]],
            ['nome' => 'Clube de Cinema e Análise Fílmica', 'areas'=>['Sociologia'=> 8]],

            ['nome' => 'Psicologia Positiva', 'areas'=>['Psicologia'=> 8]],
            ['nome' => 'Grupo de estudos em psicologia cognitiva', 'areas'=>['Psicologia'=> 6]],
            ['nome' => 'Grupo de estudos em psicologia do desenvolvimento', 'areas'=>['Psicologia'=> 6]],
            ['nome' => 'Grupo de estudos em psicologia social', 'areas'=>['Psicologia'=> 7]],
            ['nome' => 'Grupo de estudos em psicologia clínica', 'areas'=>['Psicologia'=> 7]],
            ['nome' => 'Grupo de estudos em psicanálise', 'areas'=>['Psicologia'=> 6]],
            ['nome' => 'Grupo de discussão sobre saúde mental', 'areas'=>['Psicologia'=> 6]],
            ['nome' => 'Projeto de pesquisa em psicologia', 'areas'=>['Psicologia'=> 8]],
            ['nome' => 'Projeto de extensão em psicologia', 'areas'=>['Psicologia'=> 7]],
            ['nome' => 'Clube de debate sobre temas em psicologia', 'areas'=>['Psicologia'=> 8]],
            ['nome' => 'Oficina de orientação vocacional', 'areas'=>['Psicologia'=> 3]],
            ['nome' => 'Grupo de estudos em neuropsicologia', 'areas'=>['Psicologia'=> 6]],
            ['nome' => 'Grupo de estudos em psicologia organizacional', 'areas'=>['Psicologia'=> 8]],

            ["nome" => "Clube de programação", 'areas'=>['Ciência e Tecnologia dos Computadores'=> 5]],
            ['nome' => 'Curso de desenvolvimento web', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 6]],
            ['nome' => 'Curso de Programação em Python', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 6]],
            ['nome' => 'Grupo de estudos de inteligência artificial', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 7, 'Inteligência Artificial'=> 7]],
            ['nome' => 'Curso de banco de dados', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 7, 'Ciência de Dados/Análise de Dados'=> 7]],
            ['nome' => 'Grupo de estudos de Cibersegurança', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 8, 'Ciência de Dados/Análise de Dados'=> 7]],
            ['nome' => 'Grupo de estudos de Análise de Dados', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 5, 'Ciência de Dados/Análise de Dados'=>5]],
            ['nome' => 'Olimpíada de Programação', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 8, 'Inteligência Artificial'=> 8]],
            ["nome" => "Oficina de jogos digitais", 'areas'=>['Ciência e Tecnologia dos Computadores'=> 7, 'Inteligência Artificial'=>5, 'Recreação/Entretenimento/Jogos'=>3]],
            
            ['nome' => 'Clube de robótica', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 7, 'Engenharia'=> 7]],
            ['nome' => 'Oficina de programação de robôs', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 7, 'Engenharia'=> 7, 'Inteligência Artificial'=> 6]],
            ['nome' => 'Campeonato de robótica', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 7, 'Engenharia'=> 8]],
            ['nome' => 'Desafio de robótica', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 8, 'Engenharia'=> 7, 'Engenharia Mecânica'=> 5, 'Engenharia Eletrica'=> 5]],
            ['nome' => 'Oficina de construção de robôs', 'areas'=>['Ciência e Tecnologia dos Computadores'=> 6, 'Engenharia'=> 7]],
              
        ];

        foreach($atividades as $atividade)
        {
        
            $ativ_extra = \App\Models\AtividadesExtracurriculares::where('nome', $atividade['nome'])->first();
            foreach($atividade['areas'] as $key=>$value)
            {
                $datas[] = [
                    'areas_de_conhecimento_id'=> \App\Models\AreasDeConhecimento::where('nome', $key)->first()->id,
                    'atividade_extracurricular_id'=>$ativ_extra->id,
                    'valor'=> $value
                ];
            }
        }

        $this->insertDatas('parametro_para_sugerir_atividade_extracurricular', $datas);
    
    }


    protected function attributeAreasToAcervo()
    {
        $acervos = \App\Models\Acervo::all();
        $datas = [];

        foreach($acervos as $acervo)
        {
            $datas[] =[
                'acervo_id'=> $acervo->id,
                'areas_de_conhecimento_id'=> \App\Models\AreasDeConhecimento::inRandomOrder()->first()->id
            ];
            
        }
        $this->insertDatas('acervo_areas_de_conhecimento', $datas);
    }


    protected function getDisciplinaPorArea($area)
    {
        $area_id = \App\Models\AreasDeConhecimento::where('nome', $area)->first()->id;

        $disciplina_sem_ano = DB::table('disciplinas')
            ->whereIn('id', function ($query) use ($area_id) {
                $query->select('disciplina_id')
                    ->from('areas_de_conhecimento_disciplina')
                    ->where('areas_de_conhecimento_id', $area_id)
                    ->distinct();
            })
            ->whereNotIn('id', function ($query) {
                $query->select('disciplina_id')
                    ->from('ano_disciplina')
                    ->distinct();
            })
            ->inRandomOrder()
            ->first();

        if ($disciplina_sem_ano) {
            return $disciplina_sem_ano->id;
        }
    }


    protected function attributeDisciplinaToAno()
    {
        $ano_disciplina  = [];

        $anos = DB::table('anos')
                ->join('nivel_escolar', 'anos.nivel_escolar_id', '=', 'nivel_escolar.id')
                ->select('anos.id as id', 'nivel_escolar.nome as nivel_escolar', 'anos.ano')
                ->get();
        
        foreach($anos as $ano)
        {
            if($ano->nivel_escolar=='Ensino Infantil' && $ano->ano==1){
                foreach(['Linguagem e Literatura I', 'Matemática I', 'Ciências I', 'Artes Visuais I', 'Música I', 'Educação Física I', 'História e Geografia I'] as $disciplina)
                {
                    $ano_disciplina[] = [
                        'ano_id'=>$ano->id,
                        'disciplina_id'=> \App\Models\Disciplina::where('nome', $disciplina)->first()->id
                    ];
                }
            }else if($ano->nivel_escolar=='Ensino Infantil' && $ano->ano==2){
                foreach(['Linguagem e Literatura II', 'Matemática II', 'Ciências II', 'Artes Visuais II', 'Música II', 'Educação Física II', 'História e Geografia II'] as $disciplina)
                {
                    $ano_disciplina[] = [
                        'ano_id'=>$ano->id,
                        'disciplina_id'=> \App\Models\Disciplina::where('nome', $disciplina)->first()->id
                    ];
                }
            }else if($ano->nivel_escolar=='Ensino Infantil' && $ano->ano==3){
                foreach(['Linguagem e Literatura III', 'Matemática III', 'Ciências III', 'Artes Visuais III', 'Música III', 'Educação Física III', 'História e Geografia III'] as $disciplina)
                {
                    $ano_disciplina[] = [
                        'ano_id'=>$ano->id,
                        'disciplina_id'=> \App\Models\Disciplina::where('nome', $disciplina)->first()->id
                    ];
                }
            }else if($ano->nivel_escolar=='Ensino Infantil' && $ano->ano==4){
                foreach(['Linguagem e Literatura IV', 'Matemática IV', 'Ciências IV', 'Artes Visuais IV', 'Música IV', 'Educação Física IV', 'História e Geografia IV'] as $disciplina)
                {
                    $ano_disciplina[] = [
                        'ano_id'=>$ano->id,
                        'disciplina_id'=> \App\Models\Disciplina::where('nome', $disciplina)->first()->id
                    ];
                }
            }else if($ano->nivel_escolar=='Ensino Infantil' && $ano->ano==5){
                foreach(['Linguagem e Literatura V', 'Matemática V', 'Ciências V', 'Artes Visuais V', 'Música V', 'Educação Física V', 'História e Geografia V'] as $disciplina)
                {
                    $ano_disciplina[] = [
                        'ano_id'=>$ano->id,
                        'disciplina_id'=> \App\Models\Disciplina::where('nome', $disciplina)->first()->id
                    ];
                }
            }else{
                    $ano_disciplina[] = [
                        'ano_id'=> $ano->id,
                        'disciplina_id'=> $this->getDisciplinaPorArea('Matemática')
                    ]; 
                    $ano_disciplina[] = [
                        'ano_id'=> $ano->id,
                        'disciplina_id'=> $this->getDisciplinaPorArea('Ciências e Conhecimentos em Geral')
                    ]; 
                    $ano_disciplina[] = [
                        'ano_id'=> $ano->id,
                        'disciplina_id'=> $this->getDisciplinaPorArea('Geografia')
                    ]; 
                    $ano_disciplina[] = [
                        'ano_id'=> $ano->id,
                        'disciplina_id'=> $this->getDisciplinaPorArea('História')
                    ]; 
            }
            $this->insertDatas('ano_disciplina', $ano_disciplina);
            $ano_disciplina = array();
        }

        
    }
}
