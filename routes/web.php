<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SubscribeNowController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\AdminTwoFactor;


Route::get('/', function () {
    return response()->json([
        'status'  => 'success',
        'message' => 'Village API is working ✅',
        'version' => 'v1.0.0',
        'time'    => now()->toDateTimeString(),
    ], 200);
});

Route::prefix('admin')->group(function () {

    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::get('login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::get('2fa', [AuthController::class, 'twoFactorPage'])->name('admin.2fa.page');
    Route::post('2fa', [AuthController::class, 'verifyTwoFactor'])->name('admin.2fa.verify');

    Route::middleware([AdminAuthenticate::class])->group(function () {
        Route::post('2fa/enable', [AuthController::class, 'enable2fa'])->name('admin.2fa.enable');
        Route::post('2fa/disable', [AuthController::class, 'disable2fa'])->name('admin.2fa.disable');
    });

    Route::middleware([AdminAuthenticate::class, AdminTwoFactor::class])->group(function () {
        Route::get('dashboard', [DashboardController::class , 'index'])->name('admin.dashboard');
        

    });
});