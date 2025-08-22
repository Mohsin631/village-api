<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\Subscription;

class SubscribeNowController extends Controller
{
    public function store(StoreSubscriptionRequest $request)
    {
        $record = Subscription::firstOrCreate(['email' => $request->validated()['email']]);

        return response()->json([
            'status'  => 'ok',
            'message' => $record->wasRecentlyCreated ? 'Subscribed' : 'Already subscribed',
            'data'    => ['email' => $record->email, 'id' => $record->id],
        ], $record->wasRecentlyCreated ? 201 : 200);
    }
}

