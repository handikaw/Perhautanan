<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForestLandController;
use App\Http\Controllers\LandActivityController;
use App\Http\Controllers\ForestProductionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ForestLandController::class, 'index'])->name('dashboard');
    Route::get('/forest/create', [ForestLandController::class, 'create'])->name('forest.create');
    Route::post('/forest', [ForestLandController::class, 'store'])->name('forest.store');
    Route::get('/forest/{id}/edit', [ForestLandController::class, 'edit'])->name('forest.edit');
    Route::put('/forest/{id}', [ForestLandController::class, 'update'])->name('forest.update');
    Route::delete('/forest/{id}', [ForestLandController::class, 'destroy'])->name('forest.destroy');

    Route::get('/kegiatan', [LandActivityController::class, 'index'])->name('kegiatan.index');
    Route::post('/kegiatan', [LandActivityController::class, 'store'])->name('kegiatan.store');
    Route::put('/kegiatan/{landActivity}', [LandActivityController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{landActivity}', [LandActivityController::class, 'destroy'])->name('kegiatan.destroy');

    Route::get('/produksi', [ForestProductionController::class, 'index'])->name('produksi.index');
    Route::post('/produksi', [ForestProductionController::class, 'store'])->name('produksi.store');
    Route::put('/produksi/{forestProduction}', [ForestProductionController::class, 'update'])->name('produksi.update');
    Route::delete('/produksi/{forestProduction}', [ForestProductionController::class, 'destroy'])->name('produksi.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';