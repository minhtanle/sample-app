<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticatedController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\StoreController;

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

Route::controller(AuthenticatedController::class)->group(function () {
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->resource('store', StoreController::class);
Route::middleware('auth:sanctum')->resource('product', ProductController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
