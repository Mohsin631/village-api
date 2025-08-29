<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoardMemberAdminController extends Controller
{
    public function index()
    {
        $members = BoardMember::orderBy('sort_order')->paginate(15);
        return view('admin.board_members.index', compact('members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en'     => 'required|string|max:255',
            'name_ar'     => 'required|string|max:255',
            'position_en' => 'required|string|max:255',
            'position_ar' => 'required|string|max:255',
            'image'       => 'required|image|max:2048',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/board'), $filename);
            $path = '/images/board/'.$filename;
        }

        BoardMember::create([
            'name'       => ['en'=>$data['name_en'],'ar'=>$data['name_ar']],
            'position'   => ['en'=>$data['position_en'],'ar'=>$data['position_ar']],
            'image'      => $path,
            'is_active'  => true,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return back()->with('status','Board member created.');
    }

    public function edit($id)
    {
        $member = BoardMember::findOrFail($id);
        return view('admin.board_members.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = BoardMember::findOrFail($id);

        $data = $request->validate([
            'name_en'     => 'required|string|max:255',
            'name_ar'     => 'required|string|max:255',
            'position_en' => 'required|string|max:255',
            'position_ar' => 'required|string|max:255',
            'image'       => 'nullable|image|max:2048',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $updateData = [
            'name'       => ['en'=>$data['name_en'],'ar'=>$data['name_ar']],
            'position'   => ['en'=>$data['position_en'],'ar'=>$data['position_ar']],
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/board'), $filename);
            $updateData['image'] = '/images/board/'.$filename;
        }

        $member->update($updateData);

        return redirect()->route('admin.board-members.index')->with('status','Board member updated.');
    }

    public function destroy($id)
    {
        BoardMember::whereKey($id)->delete();
        return back()->with('status','Board member deleted.');
    }

    public function toggleStatus($id)
    {
        $member = BoardMember::findOrFail($id);
        $member->update(['is_active'=>!$member->is_active]);
        return back()->with('status','Status updated.');
    }
}
