<?php

use App\Http\Controllers\ProfessorController;

Route::post('/attributeNota', [ProfessorController::class, 'attributeNota']);
Route::post('/makeNotaFinal', [ProfessorController::class, 'makeNotaFinal']);
