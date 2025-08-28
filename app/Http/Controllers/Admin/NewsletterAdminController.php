<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscription as Newsletter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsletterAdminController extends Controller
{
    public function index(Request $request)
    {
        $q       = $request->query('q');
        $date    = $request->query('date');

        $query = Newsletter::query()->latest();

        if ($q) {
            $query->where('email', 'like', "%{$q}%");
        }
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $items = $query->paginate(12)->withQueryString();

        return view('admin.newsletters.index', compact('items', 'q', 'date'));
    }

    public function destroy($id)
    {
        Newsletter::whereKey($id)->delete();

        return back()->with('status', 'Newsletter entry deleted.');
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'newsletters-'.now()->format('Ymd-His').'.csv';

        $q    = $request->query('q');
        $date = $request->query('date');

        $query = Newsletter::query()->latest();
        if ($q)    $query->where('email', 'like', "%{$q}%");
        if ($date) $query->whereDate('created_at', $date);

        $rows = $query->get(['email', 'created_at']);

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['email','created_at']);
            foreach ($rows as $r) {
                fputcsv($out, [$r->email, $r->created_at]);
            }
            fclose($out);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
