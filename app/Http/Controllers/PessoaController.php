<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PessoaController extends Controller
{


    public function getFoto(Request $request, $id)
    {
        if (!$id) {
            return response()->json(['success' => false, 'message' => 'O id é obrigatório'], 400);
        }
        try {
            $foto = Pessoa::getFotoById($request->id);
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
}
