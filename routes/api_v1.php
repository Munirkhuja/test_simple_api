<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\OrderController;
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
*/
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/auth_user',function (Request $request) {
        return $request->user();
    });
    Route::apiResource('order',OrderController::class);

});

