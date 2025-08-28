<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang','en');
        $cats = BlogCategory::all()->map(fn($c) => [
            'id' => $c->id,
            'name' => $c->getTranslatedName($lang)
        ]);
        return response()->json($cats);
    }
}


