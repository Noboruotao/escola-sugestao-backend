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
        if (!auth()->user()->hasRole($role)) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não tem a Nível de Acesso necessário'
            ], 403);
        }
        return null;
    }


    protected function checkPermission($role)
    {
        if (!auth()->user()->can($role)) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não tem permissão para executar este função'
            ], 403);
        }
        return null;
    }


    // $permissionResult = $this->checkPermission('acervo.create');
    // if ($permissionResult !== null) {
    //     return $permissionResult;
    // }
    
    // $roleResult = $this->checkRole('Aluno');
    // if ($roleResult !== null) {
    //     return $roleResult;
    // }
}
