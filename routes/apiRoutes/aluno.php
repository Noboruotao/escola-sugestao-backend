<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CursoController;

Route::get('/getCursosSugeridos', [AlunoController::class, 'getCursosSugeridos']);
Route::get('/getAtivExtraSugeridos', [AlunoController::class, 'getAtivExtraSugeridos']);

Route::get('/getDisciplinasEmAndamento', [AlunoController::class, 'getDisciplinasEmAndamento']);

Route::get('/getNotas/{id}', [AlunoController::class, 'getNotas']);

Route::get('/disaparecerSugerido', [AlunoController::class, 'disaparecerSugerido']);
