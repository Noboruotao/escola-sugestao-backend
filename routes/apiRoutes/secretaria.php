<?php

use App\Http\Controllers\MultaController;

Route::get('getMultas', [MultaController::class, 'getMultas']);
Route::get('getMulta/{id}', [MultaController::class, 'getMulta']);
Route::get('pagarMulta/{id}', [MultaController::class, 'pagarMulta']);
