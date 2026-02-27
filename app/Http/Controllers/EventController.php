<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'event_date' => 'required|date',
        'location' => 'required|string|max:255',
        'budget' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'status' => 'required|in:planned,ongoing,completed'
    ]);

    $validated['user_id'] = auth()->id();

    Event::create($validated);

    return redirect()->route('events.index')
                     ->with('success', 'Event created successfully');
}

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());
        return redirect()->route('events.index');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index');
    }
    public function show(Event $event)
{
    $event->load('attendees', 'user');

    return view('events.show', compact('event'));
}
}