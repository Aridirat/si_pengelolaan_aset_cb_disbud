<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CagarBudayaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MutasiDataController;
use App\Http\Controllers\PemugaranController;
use App\Http\Middleware\IsLogin;
use App\Models\User;

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout']);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::middleware([IsLogin::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/cagar_budaya', [CagarBudayaController::class, 'index'])->name('cagar_budaya.index');
    Route::get('/cagar_budaya/create', [CagarBudayaController::class, 'create'])->name('cagar_budaya.create');
    Route::post('/cagar_budaya', [CagarBudayaController::class, 'store'])->name('cagar_budaya.store'); // Simpan data
    Route::get('/cagar_budaya/{id}/edit', [CagarBudayaController::class, 'edit'])->name('cagar_budaya.edit'); // Form edit
    Route::put('/cagar_budaya/{id}', [CagarBudayaController::class, 'update'])->name('cagar_budaya.update'); // Update data
    Route::get('/cagar_budaya/{id}', [CagarBudayaController::class, 'detail'])->name('cagar_budaya.detail'); // Detail data
    Route::get('/cagar_budaya/cetak/pdf',[CagarBudayaController::class, 'cetakPdf'])->name('cagar_budaya.cetak.pdf');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create'); 
    Route::post('/user', [UserController::class, 'store'])->name('user.store'); // Simpan data
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); // Form edit
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update'); // Update data

    Route::get('/mutasi_data', [MutasiDataController::class, 'index'])->name('mutasi_data.index');
    Route::get('/mutasi_data/{id}', [MutasiDataController::class, 'detail'])->name('mutasi_data.detail');
    Route::get('/mutasi_data/cetak/pdf',[MutasiDataController::class, 'cetakPdf'])->name('mutasi_data.cetak.pdf');

    Route::get('/pemugaran', [PemugaranController::class, 'index'])->name('pemugaran.index');
    Route::get('/pemugaran/create', [PemugaranController::class, 'create'])->name('pemugaran.create');
    Route::post('/pemugaran', [PemugaranController::class, 'store'])->name('pemugaran.store');
    Route::get('/pemugaran/{pemugaran}/edit', [PemugaranController::class, 'edit'])->name('pemugaran.edit');
    Route::put('/pemugaran/{pemugaran}', [PemugaranController::class, 'update'])->name('pemugaran.update');
    Route::get('/pemugaran/{pemugaran}/verifikasi', [PemugaranController::class, 'verifikasi'])->name('pemugaran.verifikasi');
    Route::put('/pemugaran/{pemugaran}/verifikasi', [PemugaranController::class, 'verifikasiUpdate'])->name('pemugaran.verifikasi.update');
    Route::get('/pemugaran/{pemugaran}', [PemugaranController::class, 'detail'])->name('pemugaran.detail');
    Route::get('/pemugaran/cetak/pdf',[PemugaranController::class, 'cetakPdf'])->name('pemugaran.cetak.pdf');

});