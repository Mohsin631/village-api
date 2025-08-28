<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Resources\PartnerRequestResource;
use App\Models\PartnerRequest;
use Illuminate\Http\Request;
use App\Models\RecentActivity;

class PartnerRequestController extends Controller
{
    public function store(StorePartnerRequest $request)
    {
        $lang = strtolower($request->query('lang', $request->header('Accept-Language', 'en')));
        $lang = in_array($lang, ['en','ar']) ? $lang : 'en';

        $data = $request->validated();
        $data['lang'] = $lang;
        $data['ip'] = $request->ip();
        $data['user_agent'] = substr((string) $request->userAgent(), 0, 512);

        $pr = PartnerRequest::create($data);

        RecentActivity::create([
            'message' => "Partner request received from {$pr->company_name}",
            'type'    => 'partner_request'
        ]);

        return (new PartnerRequestResource($pr))
            ->additional(['status' => 'ok', 'message' => $lang === 'ar' ? 'تم إرسال الطلب' : 'Request submitted'])
            ->response()->setStatusCode(201);
    }
}

