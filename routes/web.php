<?php

use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';
require __DIR__.'/template.php';

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengujiController;

use App\Http\Controllers\Soca\UjianController;
use App\Http\Controllers\Soca\KriteriaController;
use App\Http\Controllers\Soca\IndikatorController;

use App\Http\Controllers\Osce\UjianController as UjianControllerOsce;
use App\Http\Controllers\Osce\KriteriaController as KriteriaControllerOsce;
use App\Http\Controllers\Osce\IndikatorController as IndikatorControllerOsce;
use App\Http\Controllers\Osce\StationController;
use App\Http\Controllers\AuthController;

Route::get('login', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'doLogin']);
Route::get('logout', function() {

    if(Auth::guard('web')->check()) {
        Auth::guard('web')->logout();
    } else {
        Auth::guard('penguji')->logout();

    }

    return redirect('login');

});

Route::prefix('soca')->group(function() {

    Route::prefix("ujian")->group(function() {
        Route::get('', [UjianController::class, 'index']);
        Route::get('create', [UjianController::class, 'create']);
        Route::post('store', [UjianController::class, 'store']);
    });

    Route::prefix("kriteria")->group(function() {
        Route::get('', [KriteriaController::class, 'index']);
        Route::get('create', [KriteriaController::class, 'create']);
        Route::post('store', [KriteriaController::class, 'store']);
    });

    Route::prefix("indikator")->group(function() {
        Route::get('', [IndikatorController::class, 'index']);
        Route::get('create', [IndikatorController::class, 'create']);
        Route::post('store', [IndikatorController::class, 'store']);
    });

    Route::get('exam-scheduled', [UjianController::class, 'listExamScheduled']);
    Route::get('exam-scheduling/create', [UjianController::class, 'examScheduling']);
    Route::post('exam-scheduling/store', [UjianController::class, 'doExamScheduling']);

    Route::get('penguji/list-ujian', [PengujiController::class, 'index']);
    Route::get('penguji/ujian/{id}', [PengujiController::class, 'exam']);
    Route::post('penguji/penilaian-ujian', [PengujiController::class, 'examJudgmentSoca']);
    Route::get('penguji/hasil-ujian/{id}', [PengujiController::class, 'hasilUjianSoca']);

});



Route::get('/', function () {
    // dd(Route::current()->uri());
    return view('dashboard');
});

// =============================================================================================================================================

Route::prefix('osce')->group(function() {

    Route::prefix("ujian")->group(function() {
        Route::get('', [UjianControllerOsce::class, 'index']);
        Route::get('create', [UjianControllerOsce::class, 'create']);
        Route::post('store', [UjianControllerOsce::class, 'store']);
    });

    Route::prefix("kriteria")->group(function() {
        Route::get('', [KriteriaControllerOsce::class, 'index']);
        Route::get('create', [KriteriaControllerOsce::class, 'create']);
        Route::post('store', [KriteriaControllerOsce::class, 'store']);
    });

    Route::prefix("indikator")->group(function() {
        Route::get('', [IndikatorControllerOsce::class, 'index']);
        Route::get('create', [IndikatorControllerOsce::class, 'create']);
        Route::post('store', [IndikatorControllerOsce::class, 'store']);
    });

    Route::prefix("station")->group(function() {
        Route::get('', [StationController::class, 'index']);
        Route::get('create', [StationController::class, 'create']);
        Route::post('store', [StationController::class, 'store']);
    });

    Route::get('exam-scheduled', [UjianControllerOsce::class, 'listExamScheduled']);
    Route::get('exam-scheduling/create', [UjianControllerOsce::class, 'examScheduling']);
    Route::post('exam-scheduling/store', [UjianControllerOsce::class, 'doExamScheduling']);

    Route::get('penguji/list-ujian', [PengujiController::class, 'listUjianOsce']);
    Route::get('penguji/ujian/{id}', [PengujiController::class, 'ujianOsce']);
    Route::post('penguji/penilaian-ujian', [PengujiController::class, 'examJudgmentOsce']);
    Route::get('penguji/hasil-ujian/{id}', [PengujiController::class, 'hasilUjianOsce']);
});
