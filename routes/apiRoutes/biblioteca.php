<?php

use App\Http\Controllers\AcervoContoller;
use App\Http\Controllers\AutorContoller;
use App\Http\Controllers\CategoriaContoller;

Route::get('listAcervos', [AcervoContoller::class, 'listAcervos']);
Route::post('createEmprestimo', [AcervoContoller::class, 'createEmprestimo']);

Route::get('listAllEmprestimos', [AcervoContoller::class, 'getAllEmprestimos']);
Route::get('listEmprestimosPendentes', [AcervoContoller::class, 'getEmprestimosPendentes']);

Route::get('listAutors', [AutorContoller::class, 'getAutors']);
Route::get('getAutor/{id}', [AutorContoller::class, 'getAutor']);
Route::post('createAutor', [AutorContoller::class, 'createAutor']);
Route::get('deleteAutor/{id}', [AutorContoller::class, 'deleteAutor']);

Route::get('listCategorias', [CategoriaContoller::class, 'getCategorias']);
Route::get('getAcervosByCategoria/{id}', [CategoriaContoller::class, 'getAcervosByCategoria']);

Route::post('createCategoria', [CategoriaContoller::class, 'createCategoria']);
Route::get('deleteCategoria/{id}', [CategoriaContoller::class, 'deleteCategoria']);
