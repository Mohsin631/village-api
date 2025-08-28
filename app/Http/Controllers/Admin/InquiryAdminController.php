<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\InquiryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryAdminController extends Controller
{
    public function index(Request $request)
    {
        $q        = $request->query('q');
        $date     = $request->query('date');
        $typeId   = $request->query('inquiry_type_id');
        $status   = $request->query('status');
        $priority = $request->query('priority');
        $lang     = $request->query('lang');

        $query = ContactMessage::with(['inquiryType','handledBy'])->latest();

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('full_name','like',"%{$q}%")
                  ->orWhere('email','like',"%{$q}%")
                  ->orWhere('phone','like',"%{$q}%")
                  ->orWhere('message','like',"%{$q}%");
            });
        }
        if ($date)     $query->whereDate('created_at', $date);
        if ($typeId)   $query->where('inquiry_type_id', $typeId);
        if ($status)   $query->where('status', $status);
        if ($priority) $query->where('priority', $priority);
        if ($lang)     $query->where('lang', $lang);

        $items = $query->paginate(15)->withQueryString();
        $types = InquiryType::all();

        return view('admin.inquiries.index', compact('items','types','q','date','typeId','status','priority','lang'));
    }

    public function show($id)
    {
        $inquiry = ContactMessage::with(['inquiryType','handledBy'])->findOrFail($id);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, $id)
    {
        $inquiry = ContactMessage::findOrFail($id);

        $data = $request->validate([
            'status'     => 'nullable|in:open,in_progress,resolved',
            'priority'   => 'nullable|in:low,medium,high',
            'admin_note' => 'nullable|string',
        ]);

        if (isset($data['status']) && $data['status'] === 'resolved') {
            $data['handled_at'] = now();
            $data['handled_by'] = Auth::id();
        }

        $inquiry->update($data);

        return back()->with('status', 'Inquiry updated successfully.');
    }

    public function destroy($id)
    {
        ContactMessage::whereKey($id)->delete();
        return back()->with('status','Inquiry deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', '[]');
    
        if (is_string($ids)) {
            $ids = json_decode($ids, true) ?? [];
        }
    
        if (!empty($ids)) {
            ContactMessage::whereIn('id', $ids)->delete();
        }
    
        return back()->with('status','Selected inquiries deleted.');
    }
    

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'inquiries-'.now()->format('Ymd-His').'.csv';

        $query = ContactMessage::with('inquiryType')->latest();

        if ($request->q)        $query->where('email','like',"%{$request->q}%");
        if ($request->date)     $query->whereDate('created_at', $request->date);
        if ($request->status)   $query->where('status', $request->status);
        if ($request->priority) $query->where('priority', $request->priority);
        if ($request->lang)     $query->where('lang', $request->lang);

        $rows = $query->get();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id','full_name','email','phone','inquiry_type','message','status','priority','admin_note','lang','created_at']);
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->id,
                    $r->full_name,
                    $r->email,
                    $r->phone,
                    optional($r->inquiryType)->name['en'] ?? optional($r->inquiryType)->name['ar'] ?? '',
                    $r->message,
                    $r->status,
                    $r->priority,
                    $r->admin_note,
                    $r->lang,
                    $r->created_at,
                ]);
            }
            fclose($out);
        }, $fileName, ['Content-Type'=>'text/csv; charset=UTF-8']);
    }
}
