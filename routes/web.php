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
        Route::get('{id}/edit', [UjianController::class, 'edit']);
        Route::patch('{id}', [UjianController::class, 'update']);
        Route::delete('{id}', [UjianController::class, 'delete']);
    });

    Route::prefix("kriteria")->group(function() {
        Route::get('', [KriteriaController::class, 'index']);
        Route::get('create', [KriteriaController::class, 'create']);
        Route::post('store', [KriteriaController::class, 'store']);
        Route::get('{id}/edit', [KriteriaController::class, 'edit']);
        Route::patch('{id}', [KriteriaController::class, 'update']);
        Route::delete('{id}', [KriteriaController::class, 'delete']);
    });

    Route::prefix("indikator")->group(function() {
        Route::get('', [IndikatorController::class, 'index']);
        Route::get('create', [IndikatorController::class, 'create']);
        Route::post('store', [IndikatorController::class, 'store']);
        Route::get('{id}/edit', [IndikatorController::class, 'edit']);
        Route::patch('{id}', [IndikatorController::class, 'update']);
        Route::delete('{id}', [IndikatorController::class, 'delete']);
    });

    Route::get('exam-scheduled', [UjianController::class, 'listExamScheduled']);
    Route::get('exam-scheduling/create', [UjianController::class, 'examScheduling']);
    Route::post('exam-scheduling/store', [UjianController::class, 'doExamScheduling']);
    Route::get('exam-scheduled/{id}/edit', [UjianController::class, 'editExamScheduled']);
    Route::patch('exam-scheduled/{id}', [UjianController::class, 'updateExamScheduled']);
    Route::delete('exam-scheduled/{id}', [UjianController::class, 'deleteExamScheduled']);

    Route::get('penguji/list-ujian', [PengujiController::class, 'index']);
    Route::get('penguji/ujian/{id}', [PengujiController::class, 'exam']);
    Route::post('penguji/penilaian-ujian', [PengujiController::class, 'examJudgmentSoca']);
    Route::get('penguji/hasil-ujian/{id}', [PengujiController::class, 'hasilUjianSoca']);
    Route::post('penguji/update-hasil-ujian', [PengujiController::class, 'updateHasilUjianSoca']);

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
        Route::get('{id}/edit', [UjianControllerOsce::class, 'edit']);
        Route::patch('{id}', [UjianControllerOsce::class, 'update']);
        Route::delete('{id}', [UjianControllerOsce::class, 'delete']);
    });

    Route::prefix("kriteria")->group(function() {
        Route::get('', [KriteriaControllerOsce::class, 'index']);
        Route::get('create', [KriteriaControllerOsce::class, 'create']);
        Route::post('store', [KriteriaControllerOsce::class, 'store']);
        Route::get('{id}/edit', [KriteriaControllerOsce::class, 'edit']);
        Route::patch('{id}', [KriteriaControllerOsce::class, 'update']);
        Route::delete('{id}', [KriteriaControllerOsce::class, 'delete']);
    });

    Route::prefix("indikator")->group(function() {
        Route::get('', [IndikatorControllerOsce::class, 'index']);
        Route::get('create', [IndikatorControllerOsce::class, 'create']);
        Route::post('store', [IndikatorControllerOsce::class, 'store']);
        Route::get('{id}/edit', [IndikatorControllerOsce::class, 'edit']);
        Route::patch('{id}', [IndikatorControllerOsce::class, 'update']);
        Route::delete('{id}', [IndikatorControllerOsce::class, 'delete']);
    });

    Route::prefix("station")->group(function() {
        Route::get('', [StationController::class, 'index']);
        Route::get('create', [StationController::class, 'create']);
        Route::post('store', [StationController::class, 'store']);
        Route::get('{id}/edit', [StationController::class, 'edit']);
        Route::patch('{id}', [StationController::class, 'update']);
        Route::delete('{id}', [StationController::class, 'delete']);
    });

    Route::get('exam-scheduled', [UjianControllerOsce::class, 'listExamScheduled']);
    Route::get('exam-scheduling/create', [UjianControllerOsce::class, 'examScheduling']);
    Route::post('exam-scheduling/store', [UjianControllerOsce::class, 'doExamScheduling']);
    Route::get('exam-scheduled/{id}/edit', [UjianControllerOsce::class, 'editExamScheduled']);
    Route::patch('exam-scheduled/{id}', [UjianControllerOsce::class, 'updateExamScheduled']);
    Route::delete('exam-scheduled/{id}', [UjianControllerOsce::class, 'deleteExamScheduled']);

    Route::get('penguji/list-ujian', [PengujiController::class, 'listUjianOsce']);
    Route::get('penguji/ujian/{id}', [PengujiController::class, 'ujianOsce']);
    Route::post('penguji/penilaian-ujian', [PengujiController::class, 'examJudgmentOsce']);
    Route::get('penguji/hasil-ujian/{id}', [PengujiController::class, 'hasilUjianOsce']);
});
