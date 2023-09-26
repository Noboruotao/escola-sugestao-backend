<?php

use App\Http\Controllers\ClasseController;

Route::get('/getClasses', [ClasseController::class, 'getClasses']);
Route::get('/getAlunos/{id}', [ClasseController::class, 'getAlunos']);
