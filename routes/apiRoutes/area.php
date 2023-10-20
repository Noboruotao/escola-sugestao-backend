<?php

use App\Http\Controllers\AreaDeConhecimentoController;

Route::get('getAreas', [AreaDeConhecimentoController::class, 'getAreas']);

Route::post('getEscolhas', [AreaDeConhecimentoController::class, 'getEscolhas']);
