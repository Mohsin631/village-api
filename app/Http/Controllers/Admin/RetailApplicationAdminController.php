<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetailApplication;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RetailApplicationAdminController extends Controller
{
    public function index(Request $request)
    {
        $q        = $request->query('q');
        $date     = $request->query('date');
        $lang     = $request->query('lang');
        $careerId = $request->query('career_id');

        $careers  = Career::orderBy('sort_order')->get();

        $query = RetailApplication::with('career')->latest();

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('full_name','like',"%{$q}%")
                  ->orWhere('email','like',"%{$q}%")
                  ->orWhere('phone','like',"%{$q}%")
                  ->orWhere('linkedin_url','like',"%{$q}%")
                  ->orWhere('cover_letter','like',"%{$q}%");
            });
        }
        if ($date)     $query->whereDate('created_at',$date);
        if ($lang)     $query->where('lang',$lang);
        if ($careerId) $query->where('career_id',$careerId);

        $items = $query->paginate(15)->withQueryString();

        return view('admin.retail_applications.index', compact('items','q','date','lang','careerId','careers'));
    }

    public function show($id)
    {
        $app = RetailApplication::with('career')->findOrFail($id);
        return view('admin.retail_applications.show', compact('app'));
    }

    public function destroy($id)
    {
        RetailApplication::whereKey($id)->delete();
        return back()->with('status','Retail application deleted.');
    }

    public function downloadCv($id)
    {
        $app = RetailApplication::findOrFail($id);
        if (!$app->cv_path) {
            return back()->with('status','No CV attached.');
        }

        $fullPath = public_path($app->cv_path);   
        if (!file_exists($fullPath)) {
            // try storage (if you used storage/app/public/...)
            $alt = storage_path('app/public/'.ltrim($app->cv_path,'/'));
            if (file_exists($alt)) $fullPath = $alt;
        }

        if (!file_exists($fullPath)) {
            return back()->with('status','CV file not found on server.');
        }

        $filename = basename($fullPath);
        return Response::download($fullPath, $filename);
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'retail-applications-'.now()->format('Ymd-His').'.csv';

        $query = RetailApplication::with('career')->latest();
        if ($request->q)        $query->where('full_name','like',"%{$request->q}%");
        if ($request->date)     $query->whereDate('created_at',$request->date);
        if ($request->lang)     $query->where('lang',$request->lang);
        if ($request->career_id)$query->where('career_id',$request->career_id);

        $rows = $query->get();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output','w');
            fputcsv($out, [
                'id','career_id','career_title_en','full_name','email','phone',
                'cv_path','linkedin_url','cover_letter','lang','ip','user_agent','created_at'
            ]);
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->id,
                    $r->career_id,
                    $r->career?->job_title['en'] ?? '',
                    $r->full_name,
                    $r->email,
                    $r->phone,
                    $r->cv_path,
                    $r->linkedin_url,
                    $r->cover_letter,
                    $r->lang,
                    $r->ip,
                    $r->user_agent,
                    $r->created_at,
                ]);
            }
            fclose($out);
        }, $fileName, ['Content-Type'=>'text/csv; charset=UTF-8']);
    }
}
