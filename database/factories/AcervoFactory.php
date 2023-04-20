<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class AcervoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        seedTabelasSemFK();
        
    }


    public function seedTabelasSemFK()
    {
    
        $valores = [
        
            [
                'tabela' => 'tipo_de_acervo',
                'dados' => [
                            ['tipo'=>'Livro', 'multa'=>.6],
                            ['tipo'=>'Periódicos', 'multa'=>.6],
                            ['tipo'=>'Teses e Dissertações', 'multa'=>.8],
                            ['tipo'=>'CD e DVD', 'multa'=>.8],
                            ['tipo'=>'Mapas e Atlas', 'multa'=>.6],
                            ['tipo'=>'Arquivos Digitais', 'multa'=>.7],
                            ['tipo'=>'Acervo Infantil', 'multa'=>.4],
                            ['tipo'=>'Acervo de Referência', 'multa'=>.6],
                            ['tipo'=>'Coleções Especiais', 'multa'=>.6]
                        ]
            ],
            [
                'tabela' => 'situacao_do_acervo',
                'dados' => [
                            ['situacao'=>'Disponível'],
                            ['situacao'=>'Emprestado'],
                            ['situacao'=>'Reservado'],
                            ['situacao'=>'Em Processamento Técnico'],
                            ['situacao'=>'Em Manutanção'],
                            ['situacao'=>'Extraviado'],
                            ['situacao'=>'Descartado'],
                    ]
            ],
            [
                'tabela' => 'estado_do_acervo',
                'dados' => [
                            ['estado'=>'Bom'],
                            ['estado'=>'Ótimo'],
                            ['estado'=>'Falta Páginas'],
                            ['estado'=>'Capa está Ruim'],
                            ['estado'=>'Descartado'],
                            ['estado'=>'Extraviado'],
                            ['estado'=>'Debuiado'],
                    ]
            ],
            [
                'tabela' => 'categoria',
                'dados' => [
                            ['categoria' => 'Ação e Aventura'],
                            ['categoria' => 'Arte e Música'],
                            ['categoria' => 'Autoajuda'],
                            ['categoria' => 'Biografias e Memórias'],
                            ['categoria' => 'Ciência e Tecnologia'],
                            ['categoria' => 'Clássicos'],
                            ['categoria' => 'Comics e Mangás'],
                            ['categoria' => 'Contos e Crônicas'],
                            ['categoria' => 'Educação e Didáticos'],
                            ['categoria' => 'Erótico'],
                            ['categoria' => 'Esoterismo'],
                            ['categoria' => 'Esportes e Lazer'],
                            ['categoria' => 'Ficção Científica e Fantasia'],
                            ['categoria' => 'Filosofia'],
                            ['categoria' => 'História do Brasil'],
                            ['categoria' => 'História Geral'],
                            ['categoria' => 'Horror e Suspense'],
                            ['categoria' => 'Humor'],
                            ['categoria' => 'Infantojuvenis'],
                            ['categoria' => 'LGBTQIA+'],
                            ['categoria' => 'Literatura Brasileira'],
                            ['categoria' => 'Literatura Estrangeira'],
                            ['categoria' => 'Medicina e Saúde'],
                            ['categoria' => 'Negócios e Economia'],
                            ['categoria' => 'Poesia'],
                            ['categoria' => 'Policial e Mistério'],
                            ['categoria' => 'Política'],
                            ['categoria' => 'Psicologia'],
                            ['categoria' => 'Religião e Espiritualidade'],
                            ['categoria' => 'Romance'],
                            ['categoria' => 'Terror'],
                            ['categoria' => 'Viagem'],
                    ]
            ],
            [
                'tabela' => 'idiomas',
                'dados' => [
                            ['idioma' => 'Português'],
                            ['idioma' => 'Inglês'],
                            ['idioma' => 'Espanhol'],
                            ['idioma' => 'Francês'],
                            ['idioma' => 'Alemão'],
                            ['idioma' => 'Italiano'],
                            ['idioma' => 'Japonês'],
                            ['idioma' => 'Mandarim'],
                            ['idioma' => 'Coreano'],
                            ['idioma' => 'Russo'],
                            ['idioma' => 'Árabe'],
                            ['idioma' => 'Hebraico'],
                            ['idioma' => 'Grego'],
                            ['idioma' => 'Latim']
                            ]
            ],
            [
                'tabela' => 'estados',
                'dados' => [
                            ['estado' => 'Acre', 'sigla' => 'AC'],
                            ['estado' => 'Alagoas', 'sigla' => 'AL'],
                            ['estado' => 'Amapá', 'sigla' => 'AP'],
                            ['estado' => 'Amazonas', 'sigla' => 'AM'],
                            ['estado' => 'Bahia', 'sigla' => 'BA'],
                            ['estado' => 'Ceará', 'sigla' => 'CE'],
                            ['estado' => 'Distrito Federal', 'sigla' => 'DF'],
                            ['estado' => 'Espírito Santo', 'sigla' => 'ES'],
                            ['estado' => 'Goiás', 'sigla' => 'GO'],
                            ['estado' => 'Maranhão', 'sigla' => 'MA'],
                            ['estado' => 'Mato Grosso', 'sigla' => 'MT'],
                            ['estado' => 'Mato Grosso do Sul', 'sigla' => 'MS'],
                            ['estado' => 'Minas Gerais', 'sigla' => 'MG'],
                            ['estado' => 'Pará', 'sigla' => 'PA'],
                            ['estado' => 'Paraíba', 'sigla' => 'PB'],
                            ['estado' => 'Paraná', 'sigla' => 'PR'],
                            ['estado' => 'Pernambuco', 'sigla' => 'PE'],
                            ['estado' => 'Piauí', 'sigla' => 'PI'],
                            ['estado' => 'Rio de Janeiro', 'sigla' => 'RJ'],
                            ['estado' => 'Rio Grande do Norte', 'sigla' => 'RN'],
                            ['estado' => 'Rio Grande do Sul', 'sigla' => 'RS'],
                            ['estado' => 'Rondônia', 'sigla' => 'RO'],
                            ['estado' => 'Roraima', 'sigla' => 'RR'],
                            ['estado' => 'Santa Catarina', 'sigla' => 'SC'],
                            ['estado' => 'São Paulo', 'sigla' => 'SP'],
                            ['estado' => 'Sergipe', 'sigla' => 'SE'],
                            ['estado' => 'Tocantins', 'sigla' => 'TO'],
                    ]
                ]
        ];

        foreach($valores as $valor)
        {
            if( $this->verifyTable($valor['tabela']) )
            {
                $this->insertDatas($valor['tabela'], $valor['dados']);
            }
        }
    
    }
    


    public function verifyTable($table_name)
    {
        return ( DB::table($table_name)->exists() );
    }


    public function insertDatas($table, $entrada)
    {
        $data = collect($entrada)->map(function($data){
            return $data;
        });

        DB::table($table)->insert( $data->toArray() );
    }
}
