<?php

use App\Http\Controllers\AtividadeExtracurricularController;

Route::get('/getAtivExtraTipo', [AtividadeExtracurricularController::class, 'getAtivExtraTipo']);
Route::get('/getAtivExtras', [AtividadeExtracurricularController::class, 'getAtivExtras']);
Route::get('/getAtivExtraDetail/{id}', [AtividadeExtracurricularController::class, 'getAtivExtraDetail']);
Route::get('/getAlunos', [AtividadeExtracurricularController::class, 'getAlunos']);

Route::post('attributeAtivExtraToAluno', [AtividadeExtracurricularController::class, 'attributeAtivExtraToAluno']);
Route::post('removeAlunoFromAtivExtra', [AtividadeExtracurricularController::class, 'removeAlunoFromAtivExtra']);
