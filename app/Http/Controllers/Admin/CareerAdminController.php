<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerAdminController extends Controller
{
    public function index()
    {
        $careers = Career::orderBy('sort_order')->latest()->paginate(15);
        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        return view('admin.careers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'job_title_en'        => 'required|string|max:255',
            'job_title_ar'        => 'required|string|max:255',
            'department_en'       => 'required|string|max:255',
            'department_ar'       => 'required|string|max:255',
            'location_en'         => 'required|string|max:255',
            'location_ar'         => 'required|string|max:255',
            'type_en'             => 'required|string|max:255',
            'type_ar'             => 'required|string|max:255',
            'short_description_en'=> 'required|string|max:500',
            'short_description_ar'=> 'required|string|max:500',
            'long_description_en' => 'required|string',
            'long_description_ar' => 'required|string',
            'status'              => 'required|in:active,inactive',
            'sort_order'          => 'nullable|integer|min:0',
        ]);

        Career::create([
            'job_title'         => ['en'=>$data['job_title_en'], 'ar'=>$data['job_title_ar']],
            'department'        => ['en'=>$data['department_en'], 'ar'=>$data['department_ar']],
            'location'          => ['en'=>$data['location_en'], 'ar'=>$data['location_ar']],
            'type'              => ['en'=>$data['type_en'], 'ar'=>$data['type_ar']],
            'short_description' => ['en'=>$data['short_description_en'], 'ar'=>$data['short_description_ar']],
            'long_description'  => ['en'=>$data['long_description_en'], 'ar'=>$data['long_description_ar']],
            'status'            => $data['status'],
            'sort_order'        => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.careers.index')->with('status','Career created.');
    }

    public function edit($id)
    {
        $career = Career::findOrFail($id);
        return view('admin.careers.edit', compact('career'));
    }

    public function update(Request $request, $id)
    {
        $career = Career::findOrFail($id);

        $data = $request->validate([
            'job_title_en'        => 'required|string|max:255',
            'job_title_ar'        => 'required|string|max:255',
            'department_en'       => 'required|string|max:255',
            'department_ar'       => 'required|string|max:255',
            'location_en'         => 'required|string|max:255',
            'location_ar'         => 'required|string|max:255',
            'type_en'             => 'required|string|max:255',
            'type_ar'             => 'required|string|max:255',
            'short_description_en'=> 'required|string|max:500',
            'short_description_ar'=> 'required|string|max:500',
            'long_description_en' => 'required|string',
            'long_description_ar' => 'required|string',
            'status'              => 'required|in:active,inactive',
            'sort_order'          => 'nullable|integer|min:0',
        ]);

        $career->update([
            'job_title'         => ['en'=>$data['job_title_en'], 'ar'=>$data['job_title_ar']],
            'department'        => ['en'=>$data['department_en'], 'ar'=>$data['department_ar']],
            'location'          => ['en'=>$data['location_en'], 'ar'=>$data['location_ar']],
            'type'              => ['en'=>$data['type_en'], 'ar'=>$data['type_ar']],
            'short_description' => ['en'=>$data['short_description_en'], 'ar'=>$data['short_description_ar']],
            'long_description'  => ['en'=>$data['long_description_en'], 'ar'=>$data['long_description_ar']],
            'status'            => $data['status'],
            'sort_order'        => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.careers.index')->with('status','Career updated.');
    }

    public function destroy($id)
    {
        Career::whereKey($id)->delete();
        return back()->with('status','Career deleted.');
    }
}
