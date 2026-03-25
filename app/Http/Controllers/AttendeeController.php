<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Event;

class AttendeeController extends Controller
{
    public function create(Event $event)
    {
        return view('attendees.create', compact('event'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        Attendee::create($request->all());

        return redirect()->route('events.show', $request->event_id)
            ->with('success', 'Attendee added successfully');
    }

    public function destroy(Attendee $attendee)
    {
        $event_id = $attendee->event_id;
        $attendee->delete();
        
        return redirect()->route('events.show', $event_id)
            ->with('success', 'Attendee removed successfully');
    }
}