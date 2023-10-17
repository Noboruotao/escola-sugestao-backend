<?php

use App\Http\Controllers\AcervoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\EstadoAcervoController;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\SituacaoAcervoController;
use App\Http\Controllers\TipoAcervoController;

Route::get('listAcervos', [AcervoController::class, 'listAcervos']);
Route::post('createEmprestimo', [EmprestimoController::class, 'createEmprestimo']);
Route::get('getAcervoParametros', [AcervoController::class, 'getAcervoParametros']);

Route::post('createAcervo', [AcervoController::class, 'createAcervo']);
Route::get('getAcervo/{acervo_id}', [AcervoController::class, 'getAcervo']);

Route::post('makeDevolucao', [EmprestimoController::class, 'makeDevolucao']);
Route::get('listEmprestimos', [EmprestimoController::class, 'listEmprestimos']);

Route::get('getEmprestimoDetail/{id}', [EmprestimoController::class, 'getEmprestimoDetail']);

Route::get('listAutors', [AutorController::class, 'getAutors']);
Route::get('getAutor/{id}', [AutorController::class, 'getAutor']);
Route::post('createAutor', [AutorController::class, 'createAutor']);
Route::delete('deleteAutor/{id}', [AutorController::class, 'deleteAutor']);

Route::get('listCategorias', [CategoriaController::class, 'getCategorias']);
Route::get('getAcervosByCategoria/{id}', [CategoriaController::class, 'getAcervosByCategoria']);

Route::post('createCategoria', [CategoriaController::class, 'createCategoria']);
Route::delete('deleteCategoria/{id}', [CategoriaController::class, 'deleteCategoria']);

Route::get('getCapa/{capa}', [AcervoController::class, 'getCapa']);

Route::get('listEditora', [EditoraController::class, 'listEditora']);
Route::get('getEditora/{id}', [EditoraController::class, 'getEditoraById']);


Route::get('listIdiomas', [IdiomaController::class, 'listIdiomas']);


Route::get('listAcervoTipo', [TipoAcervoController::class, 'listAcervoTipo']);

Route::get('listSituacao', [SituacaoAcervoController::class, 'listSituacao']);

Route::get('listEstado', [EstadoAcervoController::class, 'listEstado']);
