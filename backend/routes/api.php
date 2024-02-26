<?php

use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;

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
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login/verify', [LoginController::class, 'verify']);
Route::post('/uregister', [LoginController::class, 'userRegister']);
Route::post('/dregister', [LoginController::class, 'driverRegister']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('driver', DriverController::class);
    Route::put('/driver', [DriverController::class, 'updateDriver']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('user', UserController::class);
    Route::put('/user', [UserController::class, 'updateUser']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('trip', [TripController::class,'store']);
    Route::get('/trip/{trip}', [TripController::class,'show']);
    Route::post('/trip/{trip}/accept', [TripController::class, 'accept']);
    Route::post('/trip/{trip}/start', [TripController::class, 'start']);
    Route::post('/trip/{trip}/complete', [TripController::class, 'complete']);
    Route::post('/trip/{trip}/location', [TripController::class, 'updateLocation']);
});