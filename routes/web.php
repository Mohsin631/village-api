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
use App\Http\Controllers\Admin\InquiryTypeAdminController;
use App\Http\Controllers\Admin\BoardMemberAdminController;
use App\Http\Controllers\Admin\SiteSettingAdminController;
use App\Http\Controllers\Admin\PartnerRequestAdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\BlogCategoryAdminController;
use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\Admin\CareerAdminController;
use App\Http\Controllers\Admin\RetailApplicationAdminController;
use App\Http\Controllers\Admin\MailAdminController;


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

        // Inquires types
        Route::get('inquiry-types', [InquiryTypeAdminController::class, 'index'])->name('admin.inquiry-types.index');
        Route::post('inquiry-types', [InquiryTypeAdminController::class, 'store'])->name('admin.inquiry-types.store');
        Route::get('inquiry-types/{id}/edit', [InquiryTypeAdminController::class, 'edit'])->name('admin.inquiry-types.edit');
        Route::patch('inquiry-types/{id}', [InquiryTypeAdminController::class, 'update'])->name('admin.inquiry-types.update');
        Route::patch('inquiry-types/{id}/toggle', [InquiryTypeAdminController::class, 'toggleStatus'])->name('admin.inquiry-types.toggle');

        // Board Members
        Route::get('board-members', [BoardMemberAdminController::class,'index'])->name('admin.board-members.index');
        Route::post('board-members', [BoardMemberAdminController::class,'store'])->name('admin.board-members.store');
        Route::get('board-members/{id}/edit', [BoardMemberAdminController::class,'edit'])->name('admin.board-members.edit');
        Route::patch('board-members/{id}', [BoardMemberAdminController::class,'update'])->name('admin.board-members.update');
        Route::delete('board-members/{id}', [BoardMemberAdminController::class,'destroy'])->name('admin.board-members.destroy');
        Route::patch('board-members/{id}/toggle', [BoardMemberAdminController::class,'toggleStatus'])->name('admin.board-members.toggle');

        // Settings
        Route::get('settings', [SiteSettingAdminController::class,'edit'])->name('admin.settings.edit');
        Route::post('settings', [SiteSettingAdminController::class,'update'])->name('admin.settings.update');

        // Partner Requests
        Route::get('partner-requests',        [PartnerRequestAdminController::class,'index'])->name('admin.partner-requests.index');
        Route::get('partner-requests/{id}',   [PartnerRequestAdminController::class,'show'])->name('admin.partner-requests.show');
        Route::delete('partner-requests/{id}',[PartnerRequestAdminController::class,'destroy'])->name('admin.partner-requests.destroy');
        Route::get('partner-requests-export', [PartnerRequestAdminController::class,'export'])->name('admin.partner-requests.export');

        // Profile
        Route::get('profile', [ProfileController::class,'edit'])->name('admin.profile.edit');
        Route::post('profile', [ProfileController::class,'update'])->name('admin.profile.update');

        // Blog Categories
        Route::get('blog-categories', [BlogCategoryAdminController::class,'index'])->name('admin.blog-categories.index');
        Route::post('blog-categories', [BlogCategoryAdminController::class,'store'])->name('admin.blog-categories.store');
        Route::get('blog-categories/{id}/edit', [BlogCategoryAdminController::class,'edit'])->name('admin.blog-categories.edit');
        Route::patch('blog-categories/{id}', [BlogCategoryAdminController::class,'update'])->name('admin.blog-categories.update');
        Route::delete('blog-categories/{id}', [BlogCategoryAdminController::class,'destroy'])->name('admin.blog-categories.destroy');

        // Blogs
        Route::get('blogs', [BlogAdminController::class,'index'])->name('admin.blogs.index');
        Route::get('blogs/create', [BlogAdminController::class,'create'])->name('admin.blogs.create');
        Route::post('blogs', [BlogAdminController::class,'store'])->name('admin.blogs.store');
        Route::get('blogs/{id}/edit', [BlogAdminController::class,'edit'])->name('admin.blogs.edit');
        Route::patch('blogs/{id}', [BlogAdminController::class,'update'])->name('admin.blogs.update');
        Route::delete('blogs/{id}', [BlogAdminController::class,'destroy'])->name('admin.blogs.destroy');

        //Careers
        Route::get('careers', [CareerAdminController::class,'index'])->name('admin.careers.index');
        Route::get('careers/create', [CareerAdminController::class,'create'])->name('admin.careers.create');
        Route::post('careers', [CareerAdminController::class,'store'])->name('admin.careers.store');
        Route::get('careers/{id}/edit', [CareerAdminController::class,'edit'])->name('admin.careers.edit');
        Route::patch('careers/{id}', [CareerAdminController::class,'update'])->name('admin.careers.update');
        Route::delete('careers/{id}', [CareerAdminController::class,'destroy'])->name('admin.careers.destroy');

        // Retail Applications  
        Route::get('retail-applications',            [RetailApplicationAdminController::class,'index'])->name('admin.retail-applications.index');
        Route::get('retail-applications/export',     [RetailApplicationAdminController::class,'export'])->name('admin.retail-applications.export');
        Route::get('retail-applications/{id}',       [RetailApplicationAdminController::class,'show'])->name('admin.retail-applications.show');
        Route::get('retail-applications/{id}/cv',    [RetailApplicationAdminController::class,'downloadCv'])->name('admin.retail-applications.cv');
        Route::delete('retail-applications-delete/{id}',    [RetailApplicationAdminController::class,'destroy'])->name('admin.retail-applications.destroy');

        //Send mails
        Route::get('send-mail',  [MailAdminController::class, 'create'])->name('admin.mail.create');
        Route::post('send-mail', [MailAdminController::class, 'send'])->name('admin.mail.send');
    });
});