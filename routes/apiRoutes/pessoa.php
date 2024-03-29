<?php

use App\Http\Controllers\PessoaController;
use App\Http\Controllers\CursoController;

Route::get('foto/{id}', [PessoaController::class, 'getFoto']);
Route::get('getPessoa/{id}', [PessoaController::class, 'getPessoa']);
Route::get('getAcervosEmprestados', [PessoaController::class, 'getAcervosEmprestados']);
Route::get('getPessoaListWithCpf', [PessoaController::class, 'getPessoaListWithCpf']);
