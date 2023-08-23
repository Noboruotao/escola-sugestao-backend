<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('check', [AuthController::class, 'check']);
});
