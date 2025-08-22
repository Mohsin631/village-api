<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function contact(Request $request)
    {
        $data = SiteSetting::getValue('contact', []);
        return response()->json($data, 200);
    }

    public function show(string $key)
    {
        $data = SiteSetting::getValue($key, null);
        if ($data === null) {
            return response()->json(['status'=>'error','message'=>'Setting not found'], 404);
        }
        return response()->json($data, 200);
    }
}
