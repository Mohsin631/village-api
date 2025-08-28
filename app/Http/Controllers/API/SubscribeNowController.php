<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\Subscription;
use App\Jobs\SendGlobalMail;
use App\Models\RecentActivity;

class SubscribeNowController extends Controller
{
    public function store(StoreSubscriptionRequest $request)
    {
        $record = Subscription::firstOrCreate(['email' => $request->validated()['email']]);

        RecentActivity::create([
            'message' => "New inquiry from {$record->email}",
            'type'    => 'inquiry'
        ]);

        return response()->json([
            'status'  => 'ok',
            'message' => $record->wasRecentlyCreated ? 'Subscribed' : 'Already subscribed',
            'data'    => ['email' => $record->email, 'id' => $record->id],
        ], $record->wasRecentlyCreated ? 201 : 200);
    }

    public function testMail()
    {

        SendGlobalMail::dispatch(
            toEmail: "mohsinjaleel8@gmail.com",
            subjectLine: "Application Received – Retail Leasing Coordinator",
            messageBody: "
                Dear John Doe,<br><br>
                Thank you for applying for the position of <strong>Retail Leasing Coordinator</strong> at The Village.<br><br>
                Our HR team will review your application and contact you if your profile matches the requirements.<br><br>
                Best regards,<br>
                <strong>The Village Careers Team</strong>
            ",
            lang: 'en'
        );

        SendGlobalMail::dispatch(
            toEmail: "mohsinjaleel8@gmail.com",
            subjectLine: "تم استلام طلبك – منسق تأجير التجزئة",
            messageBody: "
                عزيزي <strong>جون دو</strong>,<br><br>
                نشكرك على التقديم لوظيفة <strong>منسق تأجير التجزئة</strong> في القرية.<br><br>
                سيقوم فريق الموارد البشرية لدينا بمراجعة طلبك والتواصل معك إذا كانت مؤهلاتك مطابقة لمتطلبات الوظيفة.<br><br>
                مع أطيب التحيات,<br>
                <strong>فريق التوظيف – القرية</strong>
            ",
            lang: 'ar'
        );        
        

        return response()->json(['status'=>'ok','message'=>'Mail queued']);
    }
}

