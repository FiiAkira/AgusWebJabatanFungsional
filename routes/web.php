<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Jika user sudah login, kirim ke dashboard, jika tidak kirim ke halaman login
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

// Document routes (arsip) - but require authentication
Route::middleware('auth')->group(function () {
    Route::get('/arsip-saya', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/arsip-saya/upload', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/arsip-saya', [DocumentController::class, 'store'])->name('documents.store');
});

require __DIR__.'/auth.php';
