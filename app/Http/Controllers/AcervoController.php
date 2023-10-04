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
        $this->middleware('auth:api', ['except' => ['getCapa', 'listAcervos']]);
        $this->acervo = $acervo;
    }


    public function listAcervos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $sortColumn = $request->input('sortColumn');
        $sortOrder = $request->input('sortOrder');
        $search = $request->query('search', null);

        $resp = $this->acervo->getAcervoList($page, $limit, true, $sortColumn, $sortOrder, $search);

        $responseData = [
            'success' => true,
            'data' => $resp['data'],
            'count' => $resp['count']
        ];

        return response()->json($responseData, 200);
    }


    public function getAcervo(Request $request)
    {
        $acervo_id = $request->acervo_id;
        return response()->json(['success' => true, 'data' => $this->acervo->getAcervo($acervo_id)], 200);
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
            'data_aquisicao' => $request->input('data_aquisicao'),
        ];
        $acervo = $this->acervo->createAcervo($data);

        $capa = $request->hasFile('capa') ? $this->acervo->createCapa($acervo, $request->file('capa')) : '';
        $acervo->capa = $capa;
        $acervo->save();

        return response()->json(['success' => true, 'data' => $acervo]);
    }


    public function getAcervosBySituacao(Request $request, $id)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => $this->acervo->getAcervosBySituacao($id, $page, $limit)]);
    }


    public function getCapa(Request $request, $capa)
    {
        try {
            $capaNome = $capa;
            $filePath = 'capas/' . $capaNome;
            $fileContents = Storage::get($filePath);
            $fileType = Storage::mimeType($filePath);
            if ($fileContents) {
                return response()->make($fileContents, 200, [
                    'Content-Type' => $fileType,
                    'Content-Disposition' => 'inline; filename="' . $capa . '"',
                ]);
            } else {
                return response()->make('File not found.', 404);
            }
        } catch (\Throwable $th) {
            return response()->make($th->getMessage('nao encontrado'), 404);
        }
    }


    public function getAllAcervoLength(Request $request)
    {
        $search = $request->query('search', null);

        return response()->json(['success' => true, 'data' => $this->acervo->getAllAcervoLength($search)]);
    }
}
