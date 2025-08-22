<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status'  => 'success',
        'message' => 'Village API is working ✅',
        'version' => 'v1.0.0',
        'time'    => now()->toDateTimeString(),
    ], 200);
});
