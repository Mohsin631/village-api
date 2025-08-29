<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogCategoryAdminController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::latest()->paginate(15);
        return view('admin.blog_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);

        BlogCategory::create($data);

        return back()->with('status','Blog category created.');
    }

    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog_categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
        ]);

        $category->update($data);

        return redirect()->route('admin.blog-categories.index')->with('status','Blog category updated.');
    }

    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);

        // remove relation instead of deleting blogs
        Blog::where('blog_category_id',$category->id)->update(['blog_category_id'=>null]);

        $category->delete();

        return back()->with('status','Blog category deleted.');
    }
}
