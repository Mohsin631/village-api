<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CareerResource;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'active');
        $query = Career::query()->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('sort_order')->orderBy('id');

        // Optional pagination: ?page=1
        $items = $query->get();

        return CareerResource::collection($items);
    }
}

