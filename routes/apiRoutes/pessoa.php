<?php

use App\Http\Controllers\PessoaController;
use App\Http\Controllers\CursoController;

Route::get('foto/{id}', [PessoaController::class, 'getFoto']);
