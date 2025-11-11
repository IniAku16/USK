<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MejaStatusController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'store']);
Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');

Route::get('/password/reset', [AuthController::class, 'resetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset.submit');

Route::get('/admin/dashboard', [DashboardController::class, 'admin']);
Route::get('/waiter/dashboard', [DashboardController::class, 'waiter']);
Route::get('/kasir/dashboard', [DashboardController::class, 'kasir']);
Route::get('/owner/dashboard', [DashboardController::class, 'owner']);

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
Route::patch('/menu/{id}/toggle-soldout', [MenuController::class, 'toggleSoldOut'])->name('menu.toggleSoldOut');

Route::get('/meja', [MejaController::class, 'index'])->name('meja.index');
Route::post('/meja', [MejaController::class, 'store'])->name('meja.store');
Route::get('/meja/hapus/{id}', [MejaController::class, 'destroy'])->name('meja.destroy');

Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
Route::post('/pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
Route::get('/api/pesanan-pelanggan/{id}', [PesananController::class, 'getPesananPelanggan'])->name('pesanan.pelanggan');

Route::controller(PelangganController::class)->group(function () {
    Route::get('/pelanggan', 'index')->name('pelanggan.index');
    Route::post('/pelanggan', 'store')->name('pelanggan.store');
    Route::put('/pelanggan/{id}', 'update')->name('pelanggan.update');
    Route::delete('/pelanggan/{id}', 'destroy')->name('pelanggan.destroy');
});

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi/{id}/bayar', [TransaksiController::class, 'pay'])->name('transaksi.pay');
Route::get('/transaksi/{id}/download-pdf', [TransaksiController::class, 'downloadPdf'])->name('transaksi.download-pdf');

// Laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export/csv', [LaporanController::class, 'exportCsv'])->name('laporan.export.csv');
Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

// Status Meja
Route::get('/api/meja-status', [MejaStatusController::class, 'getMejaStatus'])->name('meja.status');
Route::post('/api/meja-status', [MejaStatusController::class, 'updateMejaStatus'])->name('meja.status.update');
