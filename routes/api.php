<?php

use App\Http\Controllers\api\ApiPersonaController;
use App\Http\Controllers\api\ApiSolicitudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

*/
Route::get('api-solicitud/getFiador/{id}', [ApiSolicitudController::class, 'getFiador']);
Route::get('api-solicitud/getRecibos/{id}', [ApiSolicitudController::class, 'getRecibos']);
Route::get('api-solicitud/AddRecibo/{id}', [ApiSolicitudController::class, 'AddRecibo']);
Route::resource('api-solicitud', ApiSolicitudController::class);
Route::resource('api-persona', ApiPersonaController::class);


