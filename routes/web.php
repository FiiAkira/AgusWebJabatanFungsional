<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', [DocumentController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ROUTE DOKUMEN LENGKAP (CRUD)
Route::middleware('auth')->group(function () {
    // 1. Tampilkan & Upload
    Route::get('/arsip-saya', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/arsip-saya/upload', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/arsip-saya', [DocumentController::class, 'store'])->name('documents.store');

    // 2. Edit & Update (BARU)
    Route::get('/arsip-saya/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/arsip-saya/{id}', [DocumentController::class, 'update'])->name('documents.update');

    // 3. Hapus (BARU)
    Route::delete('/arsip-saya/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // 4. Verifikasi
    Route::patch('/documents/{id}/verify', [DocumentController::class, 'verify'])->name('documents.verify');
});

require __DIR__.'/auth.php';