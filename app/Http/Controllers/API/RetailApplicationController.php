<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRetailApplicationRequest;
use App\Http\Resources\RetailApplicationResource;
use App\Models\RetailApplication;
use Illuminate\Support\Facades\Storage;

class RetailApplicationController extends Controller
{
    public function store(StoreRetailApplicationRequest $request)
    {
        $lang = strtolower($request->query('lang', $request->header('Accept-Language', 'en')));
        $lang = in_array($lang, ['en','ar']) ? $lang : 'en';

        $cvPath = $request->file('cv')->store('cvs', 'public');

        $app = RetailApplication::create([
            'full_name'   => $request->full_name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'cv_path'     => $cvPath,
            'linkedin_url'=> $request->linkedin_url,
            'cover_letter'=> $request->cover_letter,
            'lang'        => $lang,
            'ip'          => $request->ip(),
            'user_agent'  => substr((string) $request->userAgent(), 0, 512),
        ]);

        return (new RetailApplicationResource($app))
            ->additional(['status'=>'ok','message'=> $lang === 'ar' ? 'تم إرسال الطلب' : 'Application submitted'])
            ->response()->setStatusCode(201);
    }
}

