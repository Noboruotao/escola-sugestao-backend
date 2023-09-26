<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CursoController;

Route::get('/getCursosSugeridos', [AlunoController::class, 'getCursosSugeridos']);
Route::get('/getAtivExtraSugeridos', [AlunoController::class, 'getAtivExtraSugeridos']);

Route::get('/getDisciplinasEmAndamento', [AlunoController::class, 'getDisciplinasEmAndamento']);

Route::get('/getNotas/{id}', [AlunoController::class, 'getNotas']);


// Route::get('/getDisciplinaNotas/{id}', [AlunoController::class, 'getDisciplinaNotas']);


// Route::get('/getClasseNotas', [AlunoController::class, 'getClasseNotas']);
