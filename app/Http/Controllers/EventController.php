<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Client;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('client')->latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $clients = Client::all();
        $statuses = ['planning', 'confirmed', 'ongoing', 'completed', 'cancelled'];
        return view('events.create', compact('clients', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,confirmed,ongoing,completed,cancelled'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['budget'] = $request->budget ?? 0;

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Event created successfully');
    }

    public function show(Event $event)
    {
        // Load relationships as specified in Chapter 4 [cite: 207]
        $event->load(['services.vendor', 'attendees', 'client']);

        // Logic directly from your Report's Sample Code 
        $totalServices = $event->services->sum('cost');
        $remainingBudget = $event->budget - $totalServices;
        $budgetUsage = $event->budget > 0 ? ($totalServices / $event->budget) * 100 : 0;
        
        $attendeeCount = $event->attendees->count();
        $serviceCount = $event->services->count();

        return view('events.show', compact(
            'event',
            'totalServices',
            'remainingBudget',
            'budgetUsage',
            'attendeeCount',
            'serviceCount'
        ));
    }

    public function edit(Event $event)
    {
        $clients = Client::all();
        $statuses = ['planning', 'confirmed', 'ongoing', 'completed', 'cancelled'];
        return view('events.edit', compact('event', 'clients', 'statuses'));
    }

    public function update(Request $request, Event $event)
    {
        // 1. Validate the data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,confirmed,ongoing,completed,cancelled'
        ]);

        // 2. Perform the update
        $event->update($validated);

        // 3. Redirect to the SHOW page so you can see the updated details immediately
        return redirect()->route('events.show', $event->id)->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully');
    }
}