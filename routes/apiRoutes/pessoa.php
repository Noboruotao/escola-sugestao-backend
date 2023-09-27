<?php

use App\Http\Controllers\PessoaController;
use App\Http\Controllers\CursoController;

Route::get('foto/{id}', [PessoaController::class, 'getFoto']);
Route::get('getPessoa/{id}', [PessoaController::class, 'getPessoa']);
