<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\InquiryTypeController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\NewsletterController;
use App\Http\Controllers\API\SubscribeNowController;

Route::prefix('v1')->group(function () {
    Route::get('inquiry-types', [InquiryTypeController::class, 'index']);
    Route::post('contact', [ContactController::class, 'store']);
    Route::post('newsletter', [NewsletterController::class, 'subscribe']);
    Route::post('subscribe',  [SubscribeNowController::class, 'store']);  
});

Route::fallback(function () {
    return response()->json([
        'status'  => 'error',
        'message' => 'Route not found',
    ], 404);
});