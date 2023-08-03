<?php

return [

    'tipos_acervo' => [
        ['tipo' => 'Livro', 'multa' => 0.6],
        ['tipo' => 'Periódicos', 'multa' => 0.6],
        ['tipo' => 'Teses e Dissertações', 'multa' => 0.8],
        ['tipo' => 'CD e DVD', 'multa' => 0.8],
        ['tipo' => 'Mapas e Atlas', 'multa' => 0.6],
        ['tipo' => 'Arquivos Digitais', 'multa' => 0.7],
        ['tipo' => 'Acervo Infantil', 'multa' => 0.4],
        ['tipo' => 'Acervo de Referência', 'multa' => 0.6],
        ['tipo' => 'Coleções Especiais', 'multa' => 0.6]
    ],

    'estados_acervo' => [
        ['estado' => 'Bom'],
        ['estado' => 'Ótimo'],
        ['estado' => 'Falta Páginas'],
        ['estado' => 'Capa está Ruim'],
        ['estado' => 'Descartado'],
        ['estado' => 'Extraviado'],
        ['estado' => 'Debuiado'],
    ],

    'situacao_acervo' => [
        ['situacao' => 'Disponível'],
        ['situacao' => 'Emprestado'],
        ['situacao' => 'Reservado'],
        ['situacao' => 'Em Processamento Técnico'],
        ['situacao' => 'Em Manutanção'],
        ['situacao' => 'Extraviado'],
        ['situacao' => 'Descartado'],
    ],

    'categorias_acervo' => [
        ['categoria' => 'Ação e Aventura'],
        ['categoria' => 'Arte e Música'],
        ['categoria' => 'Autoajuda'],
        ['categoria' => 'Biografias e Memórias'],
        ['categoria' => 'Ciência e Tecnologia'],
        ['categoria' => 'Clássicos'],
        ['categoria' => 'Comics e Mangás'],
        ['categoria' => 'Contos e Crônicas'],
        ['categoria' => 'Educação e Didáticos'],
        ['categoria' => 'Esoterismo'],
        ['categoria' => 'Esportes e Lazer'],
        ['categoria' => 'Ficção Científica e Fantasia'],
        ['categoria' => 'Filosofia'],
        ['categoria' => 'História do Brasil'],
        ['categoria' => 'História Geral'],
        ['categoria' => 'Horror e Suspense'],
        ['categoria' => 'Humor'],
        ['categoria' => 'Infantojuvenis'],
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
    ],

    'locale' => [
        1 => 'pt_BR',
        2 => 'pt_PT',
        3 => 'en_US',
        4 => 'es_ES',
        5 => 'fr_FR',
        6 => 'de_DE',
        7 => 'it_IT',
        8 => 'ja_JP',
        9 => 'zh_CN',
        10 => 'ko_KR',
        11 => 'ru_RU',
        12 => 'ar_SA',
        13 => 'he_IL',
        14 => 'el_GR',
        15 => 'en_US',
    ],

    'idiomas' => [
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
    ],

    'nacionalidade' => [
        [
            'nacionalidade' => 'Brasil',
            'idioma_oficial_id' => 1
        ],
        [
            'nacionalidade' => 'Portugal',
            'idioma_oficial_id' => 1
        ],
        [
            'nacionalidade' => 'Estados Unidos',
            'idioma_oficial_id' => 2
        ],
        [
            'nacionalidade' => 'Espanha',
            'idioma_oficial_id' => 3
        ],
        [
            'nacionalidade' => 'França',
            'idioma_oficial_id' => 4
        ],
        [
            'nacionalidade' => 'Alemanha',
            'idioma_oficial_id' => 5
        ],
        [
            'nacionalidade' => 'Itália',
            'idioma_oficial_id' => 6
        ],
        [
            'nacionalidade' => 'Japão',
            'idioma_oficial_id' => 7
        ],
        [
            'nacionalidade' => 'China',
            'idioma_oficial_id' => 8
        ],
        [
            'nacionalidade' => 'Coreia do Sul',
            'idioma_oficial_id' => 9
        ],
        [
            'nacionalidade' => 'Rússia',
            'idioma_oficial_id' => 10
        ],
        [
            'nacionalidade' => 'Emirados Árabes Unidos',
            'idioma_oficial_id' => 11
        ],
        [
            'nacionalidade' => 'Israel',
            'idioma_oficial_id' => 12
        ],
        [
            'nacionalidade' => 'Grécia',
            'idioma_oficial_id' => 13
        ],
        [
            'nacionalidade' => 'Vaticano',
            'idioma_oficial_id' => 14
        ],
    ],

    'estados' => [
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
    ],

    'acervoCapa' => [
        1 => 'images/acervo_capa/book.png',
        2 => 'images/acervo_capa/book1_green.png',
        3 => 'images/acervo_capa/book2_orange.png',
        4 => 'images/acervo_capa/media_disc_silver.png',
        5 => 'images/acervo_capa/map_book.png',
        6 => 'images/acervo_capa/media_digital.png',
        7 => 'images/acervo_capa/book_kamishibai_set.png',
        8 => 'images/acervo_capa/book3_blue.png',
        9 => 'images/acervo_capa/book_yoko.png'
    ],

];
