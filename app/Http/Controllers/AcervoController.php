<?php

namespace App\Http\Controllers;

use App\Models\Acervo;
use App\Models\Autor;
use Illuminate\Http\Request;

class AcervoController extends Controller
{
    public function listAcervos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Acervo::getAcervoList($page, $limit)], 200);
    }


    public function createAcervo(Request $request)
    {
        $data = [
            'titulo' => $request->input('titulo'),
            'subtitulo' => $request->input('subtitulo'),
            'resumo' => $request->input('resumo'),
            'tradutor' => $request->input('tradutor'),
            'autor_id' => $request->input('autor_id'),
            'idioma_id' => $request->input('idioma_id'),
            'editora_id' => $request->input('editora_id'),
            'categoria_id' => $request->input('categoria_id'),
            'tipo_id' => $request->input('tipo_id'),
            'estado_id' => $request->input('estado_id'),
            'situacao_id' => $request->input('situacao_id'),
            'IBNS' => $request->input('IBNS'),
            'ano_publicacao' => $request->input('ano_publicacao'),
            'edicao' => $request->input('edicao'),
            'data_aquisicao' => $request->input('data_aquisicao'),
        ];
        $acervo = Acervo::createAcervo($data);

        $capa = $request->hasFile('capa') ? Acervo::createCapa($acervo, $request->file('capa')) : '';
        $acervo->capa = $capa;
        $acervo->save();

        return response()->json(['success' => true, 'data' => $acervo]);
    }


    public function getAcervosBySituacao(Request $request, $id)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Acervo::getAcervosBySituacao($id, $page, $limit)]);
    }
}
