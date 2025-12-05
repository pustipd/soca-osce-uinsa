<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

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


Route::middleware('custom.basic')->group(function() {
    Route::get('/master/penguji/reset-password-all', [ApiController::class, 'resetPasswordPengujiAll']);
    Route::post('/master/penguji/reset-password-by-id/{id}', [ApiController::class, 'resetPasswordPengujiById']);
});
