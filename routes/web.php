<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\SparepartMasukController;
use App\Http\Controllers\SparepartKeluarController;
use App\Http\Controllers\SparepartRiwayatController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth')->name('dashboard');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {

    // CRUD sparepart
    Route::resource('sparepart', SparepartController::class)
        ->except(['show', 'create', 'edit']);

    // Sparepart Masuk
    Route::get('/sparepart/masuk', [SparepartMasukController::class, 'index'])
        ->name('sparepart.masuk.index');

    Route::post('/sparepart/masuk', [SparepartMasukController::class, 'store'])
        ->name('sparepart.masuk.store');

    // Sparepart Keluar
    Route::get('/sparepart/keluar', [SparepartKeluarController::class, 'index'])
        ->name('sparepart.keluar.index');

    Route::post('/sparepart/keluar', [SparepartKeluarController::class, 'store'])
        ->name('sparepart.keluar.store');

    Route::get('/sparepart/riwayat', [SparepartRiwayatController::class, 'index'])
        ->name('sparepart.riwayat.index');   
});

