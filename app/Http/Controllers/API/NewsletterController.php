<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsletterRequest;
use App\Models\NewsletterSubscription;
use App\Models\RecentActivity;

class NewsletterController extends Controller
{
    public function subscribe(StoreNewsletterRequest $request)
    {
        [$record, $created] = [null, false];

        $record = NewsletterSubscription::firstOrCreate(
            ['email' => $request->validated()['email']]
        );
        $created = $record->wasRecentlyCreated;

        RecentActivity::create([
            'message' => "New newsletter signup: {$record->email}",
            'type'    => 'newsletter'
        ]);

        return response()->json([
            'status'  => 'ok',
            'message' => $created ? 'Subscribed' : 'Already subscribed',
            'data'    => ['email' => $record->email, 'id' => $record->id],
        ], $created ? 201 : 200);
    }
}

