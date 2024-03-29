<?php

use App\Http\Controllers\ProfessorController;

Route::post('/attributeNota', [ProfessorController::class, 'attributeNota']);
Route::post('/makeNotaFinal', [ProfessorController::class, 'makeNotaFinal']);

Route::get('/getAlunosClasse', [ProfessorController::class, 'getAlunosClasse']);

Route::get('/getTipoAvaliacao', [ProfessorController::class, 'getTipoAvaliacao']);
