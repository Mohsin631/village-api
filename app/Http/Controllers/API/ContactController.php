<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request)
    {
        $lang = strtolower($request->query('lang', $request->header('Accept-Language', 'en')));
        $lang = in_array($lang, ['en','ar']) ? $lang : 'en';

        $data = $request->validated();
        $data['lang'] = $lang;
        $data['ip'] = $request->ip();
        $data['user_agent'] = substr((string) $request->userAgent(), 0, 512);

        $msg = ContactMessage::create($data);

        // Optional: dispatch job/email/notification here

        return (new ContactMessageResource($msg))
            ->additional(['status' => 'ok'])
            ->response()
            ->setStatusCode(201);
    }
}

