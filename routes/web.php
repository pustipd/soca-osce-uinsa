<?php

use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';
require __DIR__.'/template.php';

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengujiController;

use App\Http\Controllers\Soca\UjianController;
use App\Http\Controllers\Soca\KriteriaController;
use App\Http\Controllers\Soca\IndikatorController;
use App\Http\Controllers\Soca\KategoriController;
use App\Http\Controllers\Soca\PenjadwalanController;

use App\Http\Controllers\Osce\UjianController as UjianControllerOsce;
use App\Http\Controllers\Osce\KriteriaController as KriteriaControllerOsce;
use App\Http\Controllers\Osce\IndikatorController as IndikatorControllerOsce;
use App\Http\Controllers\Osce\PenjadwalanController as PenjadwalanControllerOsce;
use App\Http\Controllers\Osce\StationController;
use App\Http\Controllers\AuthController;

Route::get('/', function() {
    return redirect("login");
});
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

    Route::prefix("kategori")->group(function() {
        Route::get('', [KategoriController::class, 'index']);
        Route::get('create', [KategoriController::class, 'create']);
        Route::post('store', [KategoriController::class, 'store']);
        Route::get('{id}/edit', [KategoriController::class, 'edit']);
        Route::patch('{id}', [KategoriController::class, 'update']);
        Route::delete('{id}', [KategoriController::class, 'delete']);
    });

    Route::prefix("ujian")->group(function() {
        Route::get('', [UjianController::class, 'index']);
        Route::get('change-status/{id}', [UjianController::class, 'updateStatusUjian']);
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

    Route::prefix("penjadwalan")->group(function() {
        Route::post('/mapping/import', [PenjadwalanController::class, 'importDataMahasiswa']);
        Route::get('', [PenjadwalanController::class, 'index']);
        Route::get('mapping/{id}', [PenjadwalanController::class, 'mappingWithMahasiswa']);
        Route::post('mapping', [PenjadwalanController::class, 'doMappingWithMahasiswa']);
        Route::get('create', [PenjadwalanController::class, 'create']);
        Route::post('store', [PenjadwalanController::class, 'store']);
        Route::get('{id}/edit', [PenjadwalanController::class, 'edit']);
        Route::patch('{id}', [PenjadwalanController::class, 'update']);
        Route::delete('{id}', [PenjadwalanController::class, 'delete']);
    });

    Route::post('penguji/ujian/check-gap-point', [PengujiController::class, 'checkGapPoint']);
    Route::get('penguji/list-ujian', [PengujiController::class, 'index']);
    Route::get('penguji/ujian/{id}/tidak-hadir', [PengujiController::class, 'mahasiswaAbsenSoca']);
    Route::get('penguji/ujian/{id}', [PengujiController::class, 'exam']);
    Route::post('penguji/penilaian-ujian', [PengujiController::class, 'examJudgmentSoca']);
    Route::get('penguji/hasil-ujian/{id}', [PengujiController::class, 'hasilUjianSoca']);
    Route::post('penguji/update-hasil-ujian', [PengujiController::class, 'updateHasilUjianSoca']);

});



// Route::get('/', function () {
//     // dd(Route::current()->uri());
//     return view('dashboard');
// });

// =============================================================================================================================================

Route::prefix('osce')->group(function() {

    Route::prefix("ujian")->group(function() {
        Route::get('', [UjianControllerOsce::class, 'index']);
        Route::get('change-status/{id}', [UjianControllerOsce::class, 'updateStatusUjian']);
        Route::get('create', [UjianControllerOsce::class, 'create']);
        Route::post('store', [UjianControllerOsce::class, 'store']);
        Route::get('{id}/edit', [UjianControllerOsce::class, 'edit']);
        Route::patch('{id}', [UjianControllerOsce::class, 'update']);
        Route::delete('{id}', [UjianControllerOsce::class, 'delete']);

        Route::prefix("station")->group(function() {
            Route::get('{ujian_id}', [StationController::class, 'index']);
            Route::get('{ujian_id}/create', [StationController::class, 'create']);
            Route::post('{ujian_id}/store', [StationController::class, 'store']);
            Route::get('{ujian_id}/{id}/edit', [StationController::class, 'edit']);
            Route::patch('{ujian_id}/{id}', [StationController::class, 'update']);
            Route::delete('{ujian_id}/{id}', [StationController::class, 'delete']);
        });
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

    Route::prefix('penjadwalan')->group(function() {

        Route::prefix('mapping')->group(function() {
            Route::post('/import', [PenjadwalanControllerOsce::class, 'importDataMahasiswa']);
            Route::get('{id}', [PenjadwalanControllerOsce::class, 'mapping']);
            Route::post('', [PenjadwalanControllerOsce::class, 'doMapping']);
            Route::get('{id}/edit', [PenjadwalanControllerOsce::class, 'editMapping']);
            Route::patch('{id}', [PenjadwalanControllerOsce::class, 'updateMapping']);
            Route::delete('{id}', [PenjadwalanControllerOsce::class, 'deleteMapping']);
        });

        Route::get('', [PenjadwalanControllerOsce::class, 'index']);
        Route::get('create', [PenjadwalanControllerOsce::class, 'create']);
        Route::post('store', [PenjadwalanControllerOsce::class, 'store']);
        Route::get('{id}', [PenjadwalanControllerOsce::class, 'detail']);
        Route::get('{id}/edit', [PenjadwalanControllerOsce::class, 'edit']);
        Route::patch('{id}', [PenjadwalanControllerOsce::class, 'update']);
        Route::delete('{id}', [PenjadwalanControllerOsce::class, 'delete']);

    });

    Route::get('penguji/ujian/check-station/{id}', [PengujiController::class, 'checkStation']);
    Route::get('penguji/list-ujian', [PengujiController::class, 'listUjianOsce']);
    Route::get('penguji/ujian/{id}/tidak-hadir', [PengujiController::class, 'mahasiswaAbsenOsce']);
    Route::get('penguji/ujian/{id}', [PengujiController::class, 'ujianOsce']);
    Route::post('penguji/penilaian-ujian', [PengujiController::class, 'examJudgmentOsce']);
    Route::get('penguji/hasil-ujian/{id}', [PengujiController::class, 'hasilUjianOsce']);
});

Route::prefix("master")->group(function() {

    Route::prefix("penguji")->group(function() {

        Route::get("ubah-password", [AuthController::class, 'changePassword']);
        Route::post("ubah-password", [AuthController::class, 'doChangePassword']);

    });

});
