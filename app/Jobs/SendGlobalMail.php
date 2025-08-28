<?php

namespace App\Jobs;

use App\Mail\GlobalMessageMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendGlobalMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $toEmail,
        public string $subjectLine,
        public string $messageBody,
        public ?string $lang = 'en'
    ) {}

    public function handle(): void
    {
        Mail::to($this->toEmail)->send(
            new GlobalMessageMail($this->subjectLine, $this->messageBody, $this->lang)
        );
    }
}
