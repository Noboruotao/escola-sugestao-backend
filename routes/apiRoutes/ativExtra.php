<?php

use App\Http\Controllers\AtividadeExtracurricularController;

Route::get('getAtivExtra', [AtividadeExtracurricularController::class, 'getAtivExtras']);
