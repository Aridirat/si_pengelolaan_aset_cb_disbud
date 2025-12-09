<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CagarBudayaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsLogin;

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout']);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::middleware([IsLogin::class])->group(function () {
    Route::resource('/cagar-budaya', CagarBudayaController::class);
    Route::resource('/pengguna', PenggunaController::class);
    Route::get('/dashboard', [DashboardController::class, 'index']);
});