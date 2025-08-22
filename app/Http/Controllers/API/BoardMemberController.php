<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardMemberResource;
use App\Models\BoardMember;

class BoardMemberController extends Controller
{
    public function index()
    {
        $items = BoardMember::where('is_active', true)
            ->orderBy('sort_order')->orderBy('id')
            ->get();

        return BoardMemberResource::collection($items);
    }
}

