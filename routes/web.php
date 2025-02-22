<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Petugas\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Peminjam\PinjamController;
use App\Http\Controllers\Peminjam\UlasanController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Peminjam\PeminjamController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin Routes
Route::middleware('auth', 'adminMiddleware')->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/buku', BukuController::class);
    Route::resource('/admin/kategori', KategoriController::class);
    Route::resource('/admin/peminjaman', PeminjamanController::class);
});

// Petugas Routes
Route::middleware('auth', 'petugasMiddleware')->group(function(){
    Route::get('/petugas/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    // Route::resource('/petugas/buku', BukuController::class);

});

// Peminjam Routes
Route::middleware('auth', 'peminjamMiddleware')->group(function(){
    Route::get('/dashboard', [PeminjamController::class, 'index'])->name('dashboard');
    Route::get('/iventaris', [PinjamController::class, 'iventaris'])->name('iventaris');
    Route::resource('list', PinjamController::class);
    Route::resource('ulasan', UlasanController::class);
});

// // Admin and Petugas Routes
// Route::middleware('auth', ['adminMiddleware', 'petugasMiddleware'])->group(function(){
//     Route::resource('buku', BukuController::class);
// });

