<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Event;
use App\Models\Vendor;

class ServiceController extends Controller
{
    public function create(Event $event)
    {
        $vendors = Vendor::all();
        return view('services.create', compact('event', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Service::create($request->all());

        return redirect()->route('events.show', $request->event_id)
            ->with('success', 'Service added successfully');
    }

    public function destroy(Service $service)
    {
        $event_id = $service->event_id;
        $service->delete();
        
        return redirect()->route('events.show', $event_id)
            ->with('success', 'Service deleted successfully');
    }
}