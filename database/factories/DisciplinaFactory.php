<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DisciplinaFactory extends customFactory
{
    public function definition()
    {
        $disciplina = new DisciplinaFactory();

        $disciplina->insertTipoAvaliacao();
        $disciplina->insertSituacaoDisciplina();
        
    }


    protected function insertTipoAvaliacao()
    {
        $datas = [
            ['nome'=>'Primeira Avaliação Semestral(P1)'],
            ['nome'=>'Segunda Avaliação Semestral(P2)'],
            ['nome'=>'Entrega de Trabalho'],
        ];
        $this->verifyTable('tipos_de_avaliacoes', $datas);
    }


    protected function insertSituacaoDisciplina()
    {
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
}
