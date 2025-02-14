<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventReminderMail;

class SendEventReminderJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public function __construct(
        protected Event $event, protected array $emails
    ) {}

    public function handle(): void
    {
        foreach ($this->emails as $email) {
            Mail::to($email)->send(new EventReminderMail($this->event));
        }
    }
}
