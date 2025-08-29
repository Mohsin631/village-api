<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PartnerRequestAdminController extends Controller
{
    public function index(Request $request)
    {
        $q     = $request->query('q');
        $date  = $request->query('date');
        $lang  = $request->query('lang');

        $query = PartnerRequest::latest();

        if ($q) {
            $query->where(function($w) use ($q) {
                $w->where('company_name','like',"%{$q}%")
                  ->orWhere('contact_person','like',"%{$q}%")
                  ->orWhere('email','like',"%{$q}%")
                  ->orWhere('phone','like',"%{$q}%")
                  ->orWhere('services_summary','like',"%{$q}%");
            });
        }
        if ($date) $query->whereDate('created_at',$date);
        if ($lang) $query->where('lang',$lang);

        $items = $query->paginate(15)->withQueryString();

        return view('admin.partner_requests.index', compact('items','q','date','lang'));
    }

    public function show($id)
    {
        $request = PartnerRequest::findOrFail($id);
        return view('admin.partner_requests.show', compact('request'));
    }

    public function destroy($id)
    {
        PartnerRequest::whereKey($id)->delete();
        return back()->with('status','Partner request deleted.');
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'partner-requests-'.now()->format('Ymd-His').'.csv';

        $query = PartnerRequest::latest();
        if ($request->q)    $query->where('company_name','like',"%{$request->q}%");
        if ($request->date) $query->whereDate('created_at',$request->date);
        if ($request->lang) $query->where('lang',$request->lang);

        $rows = $query->get();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'id','company_name','contact_person','email','phone',
                'job_title','bank_name','bank_account','iban','vat_registration_number',
                'swift_code','location','services_summary','lang','ip','user_agent','created_at'
            ]);
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->id,$r->company_name,$r->contact_person,$r->email,$r->phone,
                    $r->job_title,$r->bank_name,$r->bank_account,$r->iban,$r->vat_registration_number,
                    $r->swift_code,$r->location,$r->services_summary,$r->lang,$r->ip,$r->user_agent,$r->created_at
                ]);
            }
            fclose($out);
        }, $fileName, ['Content-Type'=>'text/csv; charset=UTF-8']);
    }
}
