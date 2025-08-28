<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GlobalMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subjectLine,
        public string $messageBody,
        public ?string $lang = 'en'
    ) {}

    public function build()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.global_message')
            ->with([
                'subjectLine' => $this->subjectLine,
                'messageBody' => $this->messageBody,
                'lang'        => $this->lang,
            ]);
    }
}
