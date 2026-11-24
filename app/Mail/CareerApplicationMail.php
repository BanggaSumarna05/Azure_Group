<?php

namespace App\Mail;

use App\Models\Career;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CareerApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ?Career $career,
        public array $data,
        public string $cvPath,
    ) {}

    public function envelope(): Envelope
    {
        $title = $this->career?->title ?? 'General Application';
        return new Envelope(
            subject: '[Career Apply] '.$title.' — '.$this->data['name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.career-application',
            with: [
                'career' => $this->career,
                'data' => $this->data,
            ],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorage($this->cvPath)
                ->as('cv-'.$this->data['name'].'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
