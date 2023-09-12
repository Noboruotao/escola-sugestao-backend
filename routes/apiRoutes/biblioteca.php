<?php

use App\Http\Controllers\AcervoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmprestimoController;

Route::get('listAcervos', [AcervoController::class, 'listAcervos']);
Route::post('createEmprestimo', [EmprestimoController::class, 'createEmprestimo']);

Route::post('createAcervo', [AcervoController::class, 'createAcervo']);
Route::get('getAcervo/{acervo_id}', [AcervoController::class, 'getAcervo']);

Route::post('makeDevolucao', [EmprestimoController::class, 'makeDevolucao']);
Route::get('listEmprestimos', [EmprestimoController::class, 'listEmprestimos']);

Route::get('listAutors', [AutorController::class, 'getAutors']);
Route::get('getAutor/{id}', [AutorController::class, 'getAutor']);
Route::post('createAutor', [AutorController::class, 'createAutor']);
Route::get('deleteAutor/{id}', [AutorController::class, 'deleteAutor']);

Route::get('listCategorias', [CategoriaController::class, 'getCategorias']);
Route::get('getAcervosByCategoria/{id}', [CategoriaController::class, 'getAcervosByCategoria']);

Route::post('createCategoria', [CategoriaController::class, 'createCategoria']);
Route::get('deleteCategoria/{id}', [CategoriaController::class, 'deleteCategoria']);

Route::get('getCapa/{capa}', [AcervoController::class, 'getCapa']);
