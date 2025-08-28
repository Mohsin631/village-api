<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SubscribeNowController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\AdminTwoFactor;
use App\Http\Controllers\Admin\NewsletterAdminController;
use App\Http\Controllers\Admin\SubscribeNowAdminController;
use App\Http\Controllers\Admin\InquiryAdminController;

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
        // Dashboard
        Route::get('dashboard', [DashboardController::class , 'index'])->name('admin.dashboard');

        // Newsletter
        Route::get('newsletters',        [NewsletterAdminController::class, 'index'])->name('admin.newsletters.index');
        Route::delete('newsletters/{id}',[NewsletterAdminController::class, 'destroy'])->name('admin.newsletters.destroy');
        Route::get('newsletters/export', [NewsletterAdminController::class, 'export'])->name('admin.newsletters.export');
    
        // Subscribe Now
        Route::get('subscribers',        [SubscribeNowAdminController::class, 'index'])->name('admin.subscribers.index');
        Route::delete('subscribers/{id}',[SubscribeNowAdminController::class, 'destroy'])->name('admin.subscribers.destroy');
        Route::get('subscribers/export', [SubscribeNowAdminController::class, 'export'])->name('admin.subscribers.export');

        // Inquires
        Route::get('inquiries',              [InquiryAdminController::class,'index'])->name('admin.inquiries.index');
        Route::get('inquiries/{id}',         [InquiryAdminController::class,'show'])->name('admin.inquiries.show');
        Route::patch('inquiries/{id}',       [InquiryAdminController::class,'update'])->name('admin.inquiries.update');
        Route::delete('inquiries/{id}',      [InquiryAdminController::class,'destroy'])->name('admin.inquiries.destroy');
        Route::post('inquiries/bulk-delete', [InquiryAdminController::class,'bulkDelete'])->name('admin.inquiries.bulkDelete');
        Route::get('inquiries-export',       [InquiryAdminController::class,'export'])->name('admin.inquiries.export');
    });
});