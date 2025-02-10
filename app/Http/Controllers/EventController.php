<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'reminder_at'     => 'nullable|date|after_or_equal:start_date|before_or_equal:end_date',
            'reminder_emails' => 'nullable|string',
        ]);

        try {
            Event::create($validated);
            return redirect()->route('events.index')->with('success', 'Event created successfully!');
        } catch (\Throwable $th) {
            return redirect()->route('events.index')->with('danger', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'reminder_at'     => 'nullable|date|after_or_equal:start_date|before_or_equal:end_date',
            'reminder_emails' => 'nullable|string',
        ]);

        try {
            $event = Event::find($id);

            if (empty($event)) {
                return redirect()->route('events.index')->with('danger', 'Event not found!');
            }

            $event->update($validated);
            return redirect()->route('events.index')->with('success', 'Event updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->route('events.index')->with('danger', 'Something went wrong');
        }
    }
}
