<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Client; // Added this import

class AttendeeController extends Controller
{
    // Show form to add attendee to event
    public function create($event_id)
    {
        $event = Event::findOrFail($event_id);
        
        // Fetch all clients from the database for the dropdown
        $clients = Client::all();

        // Pass both the event and the clients to the view
        return view('attendees.create', [
            'event' => $event,
            'event_id' => $event_id, // Ensure this variable exists for line 9/13 of your blade
            'clients' => $clients
        ]);
    }

    // Store attendee
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20'
        ]);

        Attendee::create([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return redirect()
            ->route('events.show', $request->event_id)
            ->with('success', 'Attendee added successfully');
    }

    // Edit form
    public function edit(Attendee $attendee)
    {
        // If your edit form also has a client dropdown, add this:
        $clients = Client::all();
        return view('attendees.edit', compact('attendee'));
}

    // Update attendee
    public function update(Request $request, Attendee $attendee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20'
        ]);

        $attendee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return redirect()
            ->route('events.show', $attendee->event_id)
            ->with('success', 'Attendee updated successfully');
    }

    // Delete attendee
    public function destroy(Attendee $attendee)
    {
        $event_id = $attendee->event_id;
        $attendee->delete();

        return redirect()
            ->route('events.show', $event_id)
            ->with('success', 'Attendee removed successfully');
    }
    public function import(Request $request, Event $event)
{
    // 1. If it's a file upload
    if ($request->hasFile('attendee_list')) {
        $file = $request->file('attendee_list');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        
        // Skip header row and loop
        foreach (array_slice($data, 1) as $row) {
            if(isset($row[0])) { // Ensure name exists
                Attendee::create([
                    'event_id' => $event->id,
                    'name'     => $row[0],
                    'email'    => $row[1] ?? null,
                    'phone'    => $row[2] ?? null,
                ]);
            }
        }
        return back()->with('success', 'Guest list uploaded successfully!');
    }

    // 2. If it's just adding one guest (The fallback)
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email',
    ]);
    
    $event->attendees()->create($validated);
    return back()->with('success', 'Guest added to the list.');
}
}