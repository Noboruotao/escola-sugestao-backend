<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\Emprestimo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PessoaController extends Controller
{
    public function __construct(Pessoa $pessoa, Emprestimo $emprestimo)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->pessoa = $pessoa;
        $this->emprestimo = $emprestimo;
    }


    public function getPessoa(Request $request, $id)
    {
        $data = $this->pessoa->getPessoa($id);
        return response()->json($data);
    }

    public function getFoto(Request $request, $id)
    {
        if (!$id) {
            return response()->json(['success' => false, 'message' => 'O id é obrigatório'], 400);
        }
        try {
            $foto = $this->pessoa->getFotoById($request->id);
            if (!$foto) {
                return response()->make('File not found.', 404);
            }
            $filePath = 'fotos/' . $foto;
            $fileContents = Storage::get($filePath);
            $fileType = Storage::mimeType($filePath);
            if ($fileContents) {
                return response()->make($fileContents, 200, [
                    'Content-Type' => $fileType,
                    'Content-Disposition' => 'inline; filename="' . $foto . '"',
                ]);
            } else {
                return response()->make('File not found.', 404);
            }
        } catch (\Throwable $th) {
            return response()->make($th->getMessage(), 404);
        }
    }

    public function getAcervosEmprestados()
    {
        $emprestimo = $this->emprestimo->getUserEmprestimos();

        return response()->json([
            'success' => true,
            'data' => $emprestimo,
        ]);
    }

    public function getPessoaListWithCpf(Request $request)
    {
        $search = $request->query('search', '');

        return $this->pessoa->getPessoaListFilteredWithCpf($search);
    }
}
