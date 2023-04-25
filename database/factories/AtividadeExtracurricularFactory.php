<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;


class AtividadeExtracurricularFactory extends customFactory
{
    public function definition()
    {
        $ativExtra = new AtividadeExtracurricularFactory();

        $ativExtra->insertTipoAtivExtra();
        $ativExtra->insertAtivExtra();


        
    }


    protected function insertTipoAtivExtra()
    {
        $datas = [
            [
                'nome'=> 'Esporte'
            ],
            [
                'nome'=> 'Artes'
            ],
            [
                'nome'=> 'Clubes Acadêmicos'
            ],
            [
                'nome'=> 'Trabalho Voluntáriado'
            ],
            [
                'nome'=> 'Competições'
            ],
            [
                'nome'=> 'Habilidades Técnicas'
            ]
        ];
        $this->insertDatas('tipos_de_atividade_extracurricular', $datas);
    }


    protected function insertAtivExtra()
    {
        
    }
}
