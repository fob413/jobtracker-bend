<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\StageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthenticationController::class, 'signup']);
    Route::post('/login', [AuthenticationController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/stage', [StageController::class, 'create']);
    Route::get('/stage', [StageController::class, 'list']);
});
