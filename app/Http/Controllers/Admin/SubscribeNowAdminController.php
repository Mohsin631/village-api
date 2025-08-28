<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscribeNowAdminController extends Controller
{
    public function index(Request $request)
    {
        $q       = $request->query('q');
        $date    = $request->query('date');

        $query = Subscription::query()->latest();

        if ($q) {
            $query->where('email', 'like', "%{$q}%");
        }
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $items = $query->paginate(12)->withQueryString();

        return view('admin.subscribers.index', compact('items', 'q', 'date'));
    }

    public function destroy($id)
    {
        Subscription::whereKey($id)->delete();

        return back()->with('status', 'Subscriber deleted.');
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'subscribers-'.now()->format('Ymd-His').'.csv';

        $q    = $request->query('q');
        $date = $request->query('date');

        $query = Subscription::query()->latest();
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
