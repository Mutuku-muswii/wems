<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function create(Event $event)
    {
        return view('attendees.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20'
        ]);

        $event->attendees()->create($validated);

        return redirect()->route('events.show', $event->id)
                         ->with('success', 'Attendee added successfully');
    }

    public function destroy(Event $event, Attendee $attendee)
    {
        $attendee->delete();

        return back()->with('success', 'Attendee removed');
    }
}