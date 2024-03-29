<?php

use App\Http\Controllers\DisciplinaController;
use App\Models\Disciplina;

Route::get('listDisciplina', [DisciplinaController::class, 'getDisciplinas']);
Route::get('getUserDisciplina', [DisciplinaController::class, 'getDisciplinasOfUser']);
Route::get('getSituacaoDisciplina', [DisciplinaController::class, 'getSituacoesDisciplina']);

Route::get('getDisciplinaDetail/{id}', [DisciplinaController::class, 'getDisciplina']);

Route::post('createSituacao', [DisciplinaController::class, 'createSituacao']);
Route::delete('deleteSituacao', [DisciplinaController::class, 'deleteSituacao']);
