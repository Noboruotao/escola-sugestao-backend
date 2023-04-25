<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AreaDeConhecimentoFactory extends customFactory
{
    public function definition()
    {
        $areas = new AreaDeConhecimentoFactory();

        $areas->insertAreaConhecimento();
        
    }


    protected function insertAreaConhecimento()
    {
        $datas = [
            ['nome'=> 'Ciências e Conhecimentos em Geral'],
            ['nome'=> 'Documentação'],
            ['nome'=> 'Ciência e Tecnologia dos Computadores'],
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
            ['nome'=> 'Culinária'],
            ['nome'=> 'Administração e Equipamentos do Lar'],
            ['nome'=> 'Administração de Escritório'],
            ['nome'=> 'Telecomunicação'],
            ['nome'=> 'Impressão/Publicação/Mercado Editorial'],
            ['nome'=> 'Contabilidade'],
            ['nome'=> 'Publicidade/Marketing/Relações Públicas'],
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
            ['nome'=> 'Escoals Literárias'],
            ['nome'=> 'Críticas Literárias'],
            ['nome'=> 'Arqueologia'],
            ['nome'=> 'Pré-Historia'],
            ['nome'=> 'Geografia'],
            ['nome'=> 'Genealogia'],
            ['nome'=> 'História'],
            ['nome'=> 'Teoria e filosofia da História'],
        ];

        $this->insertDatas('areas_de_conhecimentos', $datas);

    }
}
