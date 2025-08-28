<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\InquiryTypeController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\NewsletterController;
use App\Http\Controllers\API\SubscribeNowController;
use App\Http\Controllers\API\BoardMemberController;
use App\Http\Controllers\API\SettingsController;
use App\Http\Controllers\API\PartnerRequestController;
use App\Http\Controllers\API\RetailApplicationController;
use App\Http\Controllers\API\CareerController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\BlogCategoryController;

Route::prefix('v1')->group(function () {
    Route::get('inquiry-types', [InquiryTypeController::class, 'index']);
    Route::post('contact', [ContactController::class, 'store']);
    Route::post('newsletter', [NewsletterController::class, 'subscribe']);
    Route::post('subscribe',  [SubscribeNowController::class, 'store']);  
    Route::get('board-members', [BoardMemberController::class, 'index']);
    Route::get('settings/contact', [SettingsController::class, 'contact']);
    Route::get('settings/{key}', [SettingsController::class, 'show'])->where('key', '[A-Za-z0-9_\-]+');
    Route::post('partners', [PartnerRequestController::class, 'store']);
    Route::get('careers', [CareerController::class, 'index']);
    Route::post('careers/apply', [RetailApplicationController::class, 'store']);

    // Blog api

    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('blog-categories', [BlogCategoryController::class, 'index']);
    Route::get('blogs/category/{id}', [BlogController::class, 'byCategory']);
});

Route::fallback(function () {
    return response()->json([
        'status'  => 'error',
        'message' => 'Route not found',
    ], 404);
});