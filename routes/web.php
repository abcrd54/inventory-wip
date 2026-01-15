<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\SparepartMasukController;
use App\Http\Controllers\SparepartKeluarController;
use App\Http\Controllers\SparepartRiwayatController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitBulkController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\InvoiceController;

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

     Route::get('/unit', [UnitController::class, 'index'])
        ->name('unit.index');

    Route::get('/unit/create', [UnitController::class, 'create'])
        ->name('unit.create');

    Route::post('/unit', [UnitController::class, 'store'])
        ->name('unit.store');

    Route::put('/unit/{unit}/status', [UnitController::class, 'updateStatus'])
        ->name('unit.updateStatus');

    
    Route::get('/unit/bulk-status', [UnitBulkController::class, 'index'])
        ->name('unit.bulk-status');

    Route::post('/unit/bulk-status', [UnitBulkController::class, 'update'])
        ->name('unit.bulk-status.update');
    
    Route::get('/inquiry', [InquiryController::class, 'index'])
        ->name('inquiry.index');

    Route::get('/inquiry/create', [InquiryController::class, 'create'])
        ->name('inquiry.create');

    Route::post('/inquiry', [InquiryController::class, 'store'])
        ->name('inquiry.store');

    Route::delete('/inquiry/{id}', [InquiryController::class, 'destroy'])
        ->name('inquiry.destroy');
    
    
    Route::get('invoice', [InvoiceController::class, 'index'])
        ->name('invoice.index');

    Route::get('invoice/create', [InvoiceController::class, 'selectInquiry'])
        ->name('invoice.select-inquiry');

    Route::get('invoice/create/{no_inquiry}', [InvoiceController::class, 'create'])
        ->name('invoice.create');

    Route::post('invoice', [InvoiceController::class, 'store'])
        ->name('invoice.store');

    Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])
    ->name('invoice.destroy');
    
    Route::get('/invoice/{id}/pdf', [InvoiceController::class, 'exportPdf'])
    ->name('invoice.pdf');

});

