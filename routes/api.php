<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\http\Controllers\AuthController;
use App\Http\Controllers\PessoaController;

Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('check', [AuthController::class, 'check']);

    Route::get('pessoa/foto/{id}', [PessoaController::class, 'getFoto']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'biblioteca'
], function ($router) {
    require __DIR__ . '/apiRoutes/biblioteca.php';
});
