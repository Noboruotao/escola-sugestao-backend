<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function checkRole($role)
    {
        if (!auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário Não Autenticado.'
            ]);
        }
        if (!auth()->user()->hasRole($role)) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não tem a Nível de Acesso necessário'
            ], 403);
        }
        return null;
    }


    protected function checkPermission($permission)
    {
        if (!auth()->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário Não Autenticado.'
            ]);
        }
        if (!auth()->user()->can($permission)) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não tem permissão para executar este função'
            ], 403);
        }
        return null;
    }
}
