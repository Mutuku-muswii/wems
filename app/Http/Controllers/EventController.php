<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Client;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::with('client')->get();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $clients = Client::all();

        return view('events.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'client_id' => 'required',
            'event_date' => 'required',
            'location' => 'required'
        ]);

        Event::create([
            'title' => $request->title,
            'client_id' => $request->client_id,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'budget' => $request->budget,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => auth()->id()
        ]);

        return redirect('/events')->with('success','Event created successfully');
    }

    public function show($id)
    {
        $event = Event::with(['client','attendees'])->findOrFail($id);

        return view('events.show', compact('event'));
    }

    public function destroy($id)
    {
        Event::destroy($id);

        return redirect('/events')->with('success','Event deleted');
    }

}