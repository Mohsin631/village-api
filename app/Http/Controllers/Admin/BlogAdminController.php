<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogAdminController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                => 'required|string|max:255',
            'title_ar'             => 'required|string|max:255',
            'short_description'    => 'required|string|max:255',
            'short_description_ar' => 'required|string|max:255',
            'long_description'     => 'required|string',
            'long_description_ar'  => 'required|string',
            'cover_image'          => 'required|image|max:2048',
            'blog_category_id'     => 'nullable|exists:blog_categories,id',
            'status'               => 'required|in:active,inactive',
        ]);

        $path = $request->file('cover_image')->move(public_path('images/blogs'), time().'_'.$request->file('cover_image')->getClientOriginalName());

        Blog::create([
            ...$data,
            'cover_image' => '/images/blogs/'.basename($path),
        ]);

        return redirect()->route('admin.blogs.index')->with('status','Blog created.');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.blogs.edit', compact('blog','categories'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $data = $request->validate([
            'title'                => 'required|string|max:255',
            'title_ar'             => 'required|string|max:255',
            'short_description'    => 'required|string|max:255',
            'short_description_ar' => 'required|string|max:255',
            'long_description'     => 'required|string',
            'long_description_ar'  => 'required|string',
            'cover_image'          => 'nullable|image|max:2048',
            'blog_category_id'     => 'nullable|exists:blog_categories,id',
            'status'               => 'required|in:active,inactive',
        ]);

        $updateData = $data;

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->move(public_path('images/blogs'), time().'_'.$request->file('cover_image')->getClientOriginalName());
            $updateData['cover_image'] = '/images/blogs/'.basename($path);
        }

        $blog->update($updateData);

        return redirect()->route('admin.blogs.index')->with('status','Blog updated.');
    }

    public function destroy($id)
    {
        Blog::whereKey($id)->delete();
        return back()->with('status','Blog deleted.');
    }
}
