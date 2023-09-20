<?php

use App\Http\Controllers\CursoController;

Route::get('/getCurso/{id}', [CursoController::class, 'getCurso']);
Route::get('/getCursos', [CursoController::class, 'getCursos']);
