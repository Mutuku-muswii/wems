<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Event;

class AttendeeController extends Controller
{

    public function create($id)
    {
        $event = Event::findOrFail($id);

        return view('attendees.create', compact('event'));
    }

    public function store(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable'
        ]);

        Attendee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'event_id' => $id
        ]);

        return redirect('/events')->with('success','Attendee added successfully');

    }

}