<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CagarBudayaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsLogin;
use App\Models\User;

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout']);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::middleware([IsLogin::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('/cagar-budaya', CagarBudayaController::class);


    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create'); 
    Route::post('/user', [UserController::class, 'store'])->name('user.store'); // Simpan data
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit'); // Form edit
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update'); // Update data
});