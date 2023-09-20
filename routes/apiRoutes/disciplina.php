<?php

use App\Http\Controllers\DisciplinaController;
use App\Models\Disciplina;

Route::get('listDisciplina', [DisciplinaController::class, 'getDisciplinas']);
Route::get('getUserDisciplina', [DisciplinaController::class, 'getDisciplinasOfUser']);
Route::get('getSituacaoDisciplina', [DisciplinaController::class, 'getSituacoesDisciplina']);


Route::post('createSituacao', [DisciplinaController::class, 'createSituacao']);
Route::post('deleteSituacao', [DisciplinaController::class, 'deleteSituacao']);
