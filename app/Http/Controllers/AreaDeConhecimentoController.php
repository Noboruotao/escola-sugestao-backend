<?php

namespace App\Http\Controllers;

use App\Models\AreaConhecimento;
use Illuminate\Http\Request;

class AreaDeConhecimentoController extends Controller
{
    public function __construct(AreaConhecimento $areaConhecimento)
    {
        $this->areaConhecimento = $areaConhecimento;
    }


    public function getAreas(Request $request)
    {
        $degree = $request->query('nivel', 2) == '' ? 2 : $request->query('nivel', 2);
        return $this->areaConhecimento->getAreas($degree);
    }


    public function getEscolhas(Request $request)
    {
        $escolhas = $request->input('escolhas');

        return $this->areaConhecimento->attributeAlunoEscolhas($escolhas);
    }
}
