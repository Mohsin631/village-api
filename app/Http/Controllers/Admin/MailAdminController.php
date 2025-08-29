<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\SendGlobalMail;

class MailAdminController extends Controller
{
    public function create(Request $request)
    {
        $prefill = trim((string)$request->query('emails', ''));
        return view('admin.mail.create', compact('prefill'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'emails'       => 'required|string',       // comma / newline separated
            'subjectLine'  => 'required|string|max:255',
            'messageBody'  => 'required|string',
            'lang'         => 'required|in:en,ar',
            'dispatch_now' => 'nullable|boolean',      // optional: send synchronously after response
        ]);

        // Split emails by comma, semicolon, whitespace, or newline
        $candidates = preg_split('/[,\s;]+/', $data['emails'], -1, PREG_SPLIT_NO_EMPTY) ?: [];
        // Normalize, unique, and validate
        $emails = collect($candidates)
            ->map(fn($e) => strtolower(trim($e)))
            ->filter()
            ->unique()
            ->filter(fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL))
            ->values();

        $invalids = collect($candidates)
            ->map(fn($e) => strtolower(trim($e)))
            ->filter()
            ->diff($emails)
            ->values();

        if ($emails->isEmpty()) {
            return back()->withInput()->with('status', 'No valid emails found. Please check the addresses.');
        }

        // Dispatch one job per recipient (queued)
        foreach ($emails as $to) {
            SendGlobalMail::dispatch(
                toEmail: $to,
                subjectLine: $data['subjectLine'],
                messageBody: $data['messageBody'],
                lang: $data['lang']
            ); // ->onQueue('mail')  // uncomment if you use a dedicated 'mail' queue
        }

        $msg = "Queued emails to {$emails->count()} recipient(s).";
        if ($invalids->isNotEmpty()) {
            $msg .= " Skipped invalid: " . $invalids->take(5)->implode(', ') . ($invalids->count() > 5 ? '…' : '');
        }

        return redirect()->route('admin.mail.create')->with('status', $msg);
    }
}
