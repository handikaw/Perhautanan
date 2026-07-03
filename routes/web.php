<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForestLandController;
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
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
