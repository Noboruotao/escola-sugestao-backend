<?php

use App\Http\Controllers\CursoController;

Route::get('/getCursos', [CursoController::class, 'getCursos']);
