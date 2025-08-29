<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingAdminController extends Controller
{
    public function edit()
    {
        $setting = SiteSetting::where('key','contact')->first();
        $values = $setting?->value ?? [
            "phone" => "",
            "email" => "",
            "location" => "",
            "location_google_maps" => "",
            "linkedin" => "",
            "youtube" => "",
            "twitter" => "",
            "tiktok" => "",
            "instagram" => "",
        ];

        return view('admin.settings.edit', compact('values'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'phone'               => 'nullable|string|max:50',
            'email'               => 'nullable|email|max:255',
            'location'            => 'nullable|string|max:255',
            'location_google_maps'=> 'nullable|url|max:255',
            'linkedin'            => 'nullable|url|max:255',
            'youtube'             => 'nullable|url|max:255',
            'twitter'             => 'nullable|url|max:255',
            'tiktok'              => 'nullable|url|max:255',
            'instagram'           => 'nullable|url|max:255',
        ]);

        SiteSetting::updateOrCreate(
            ['key'=>'contact'],
            ['value'=>$data,'is_public'=>true]
        );

        return back()->with('status','Settings updated successfully.');
    }
}
