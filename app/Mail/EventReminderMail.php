<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Event;

class EventReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Event $event
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder: ' . $this->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.event_reminder',
            with: [
                'event' => $this->event,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
