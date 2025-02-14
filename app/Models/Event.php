<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'reminder_at' => 'datetime',
        'reminder_emails' => 'array',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->event_reminder_id)) {
                $event->event_reminder_id = 'EVT-' . strtoupper(Str::random(8));
            }
        });
    }
}
