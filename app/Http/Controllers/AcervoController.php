<?php

namespace App\Http\Controllers;

use App\Models\Acervo;
use App\Models\Autor;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AcervoController extends Controller
{
    public function __construct(Acervo $acervo)
    {
        $this->middleware(
            'auth:api',
            [
                'except' => [
                    'getCapa',
                    'listAcervos'
                ]
            ]
        );
        $this->acervo = $acervo;
    }


    public function listAcervos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $sortColumn = $request->query('sortColumn', 'id');
        $sortOrder = $request->query('sortOrder', 'asc');
        $search = $request->query('search', null);

        return $this->acervo->getAcervoList(
            $page,
            $limit,
            $sortColumn,
            $sortOrder,
            $search
        );
    }


    public function getAcervo(Request $request)
    {
        $acervo_id = $request->acervo_id;
        return  $this->acervo
            ->getAcervo($acervo_id);
    }


    public function createAcervo(Request $request)
    {

        $permissionResult = $this->checkPermission('acervo.create');
        if ($permissionResult !== null) {
            return $permissionResult;
        }

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
        ];

        $capa = $request->hasFile('capa')
            ? $request->file('capa')
            : null;

        return $this->acervo->createAcervo(
            $data,
            $capa
        );
    }


    public function getAcervosBySituacao(
        Request $request,
        $id
    ) {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);

        return $this->acervo->getAcervosBySituacao(
            $id,
            $page,
            $limit
        );
    }


    public function getCapa(
        Request $request,
        $capa
    ) {
        return $this->acervo->getCapa($capa);
    }


    public function getAcervoParametros()
    {
        return $this->acervo
            ->getAcervoParametros();
    }
}
