<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InquiryType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InquiryTypeAdminController extends Controller
{
    public function index()
    {
        $types = InquiryType::latest()->paginate(15);
        return view('admin.inquiry_types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug'     => 'required|unique:inquiry_types,slug',
            'name_en'  => 'required|string|max:255',
            'name_ar'  => 'required|string|max:255',
            'is_active'=> 'nullable|boolean',
        ]);

        InquiryType::create([
            'slug'      => Str::slug($data['slug']),
            'name'      => ['en' => $data['name_en'], 'ar' => $data['name_ar']],
            'is_active' => $data['is_active'] ?? 1,
        ]);

        return back()->with('status','Inquiry type created.');
    }

    public function edit($id)
    {
        $type = InquiryType::findOrFail($id);
        return view('admin.inquiry_types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = InquiryType::findOrFail($id);

        $data = $request->validate([
            'slug'     => 'required|unique:inquiry_types,slug,'.$id,
            'name_en'  => 'required|string|max:255',
            'name_ar'  => 'required|string|max:255',
            'is_active'=> 'nullable|boolean',
        ]);

        $type->update([
            'slug'      => Str::slug($data['slug']),
            'name'      => ['en'=>$data['name_en'], 'ar'=>$data['name_ar']],
            'is_active' => $data['is_active'] ?? 1,
        ]);

        return redirect()->route('admin.inquiry-types.index')->with('status','Inquiry type updated.');
    }

    public function toggleStatus($id)
    {
        $type = InquiryType::findOrFail($id);
        $type->update(['is_active' => !$type->is_active]);

        return back()->with('status','Inquiry type status updated.');
    }
}
