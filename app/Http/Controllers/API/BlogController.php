<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Fetch all blogs
    public function index(Request $request)
    {
        $lang = $request->query('lang','en');
        $blogs = Blog::where('status','active')->with('category')->latest()->get();

        return response()->json($blogs->map(fn($b) => $b->translate($lang)));
    }

    // Fetch blogs by category
    public function byCategory(Request $request, $id)
    {
        $lang = $request->query('lang','en');
        $blogs = Blog::where('status','active')
            ->where('blog_category_id',$id)
            ->with('category')
            ->latest()
            ->get();

        return response()->json($blogs->map(fn($b) => $b->translate($lang)));
    }

    public function show(Request $request, $id)
    {
        $lang = $request->query('lang','en');
        $blog = Blog::with('category')->findOrFail($id);

        return response()->json($blog->translate($lang));
    }
}


