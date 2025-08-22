<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\InquiryTypeResource;
use App\Models\InquiryType;
use Illuminate\Http\Request;

class InquiryTypeController extends Controller
{
    public function index(Request $request)
    {
        $types = InquiryType::active()->orderBy('id')->get();
        return InquiryTypeResource::collection($types);
    }
}
