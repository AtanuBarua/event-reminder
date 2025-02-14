<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\SendEventReminderJob;
use Illuminate\Support\Facades\Schedule;
use App\Models\Event;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $events = Event::whereNotNull('reminder_at')
        ->whereDate('reminder_at', now()->toDateString())
        ->whereTime('reminder_at', '<=', now()->toTimeString())
        ->where('reminder_sent', false)
        ->get();

    foreach ($events as $event) {
        $emails = $event->reminder_emails ?? [];

        if (!empty($emails)) {
            dispatch(new SendEventReminderJob($event, $emails));
        }

        $event->update(['reminder_sent' => true]);
    }
})->everyMinute();
