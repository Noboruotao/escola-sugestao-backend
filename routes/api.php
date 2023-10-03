<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\http\Controllers\AuthController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AcervoController;

use App\Http\Controllers\testController;

Route::get('/getDatasForTest', [testController::class, 'getDatasForTest']);


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
        'prefix' => 'pessoa'
    ], function ($router) {
        require __DIR__ . '/apiRoutes/pessoa.php';
    });


    Route::group([
        'middleware' => 'api',
        'prefix' => 'biblioteca'
    ], function ($router) {
        require __DIR__ . '/apiRoutes/biblioteca.php';
    });


    Route::group([
        'middleware' => 'api',
        'prefix' => 'aluno'
    ], function ($router) {
        require __DIR__ . '/apiRoutes/aluno.php';
    });


    Route::group([
        'middleware' => 'api',
        'prefix' => 'curso'
    ], function ($router) {
        require __DIR__ . '/apiRoutes/curso.php';
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'ativExtra'
    ], function ($router) {
        require __DIR__ . '/apiRoutes/ativExtra.php';
    });


    Route::group([
        'middleware' => 'api',
        'prefix' => 'disciplina'
    ], function ($router) {
        require __DIR__ . '/apiRoutes/disciplina.php';
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'professor'
    ], function ($router) {
        require __DIR__ . '/apiRoutes/professor.php';
    });

    Route::group([
        'middleware' => 'api',
        'prefix' => 'classe'
    ], function ($router) {
        require __DIR__ . '/apiRoutes/classe.php';
    });
