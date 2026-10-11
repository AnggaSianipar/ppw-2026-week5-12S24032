<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;
//login hanya bisa diakses oleh user yang belum login
Route::get('/', function () {
    return redirect()->route('login');
});
//login hanya bisa diakses oleh user yang belum login
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});
//logout hanya bisa diakses oleh user yang sudah login
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
//dashboard hanya bisa diakses oleh user yang sudah login
Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
//mahasiswa, buku, kategori hanya bisa diakses oleh user dengan role admin
Route::middleware(['auth', 'role:admin'])->group(function (): void {
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('buku', BukuController::class)->except(['index', 'show']);
    Route::resource('kategori', KategoriController::class)->except(['index', 'show']);
});
//mahasiswa hanya bisa read
Route::middleware('auth')->group(function (): void {
    Route::resource('buku', BukuController::class)->only(['index', 'show']);
    Route::resource('kategori', KategoriController::class)->only(['index', 'show']);
});