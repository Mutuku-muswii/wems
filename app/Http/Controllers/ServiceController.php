<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Event;
use App\Models\Vendor;

class ServiceController extends Controller
{

    // Show all services (optional admin view)
    public function index()
    {
        $services = Service::with(['event','vendor'])->get();

        return view('services.index', compact('services'));
    }


    // Show form to create a service for an event
    public function create($event_id)
    {
        $event = Event::findOrFail($event_id);
        $vendors = Vendor::all();

        return view('services.create', compact('event','vendors'));
    }


    // Store service
    public function store(Request $request)
    {

        $request->validate([
            'event_id' => 'required',
            'name' => 'required',
            'cost' => 'required|numeric'
        ]);

        Service::create([
            'event_id' => $request->event_id,
            'vendor_id' => $request->vendor_id,
            'name' => $request->name,
            'cost' => $request->cost
        ]);

        return redirect()
            ->route('events.show', $request->event_id)
            ->with('success','Service added successfully');
    }


    // Edit service
    public function edit(Service $service)
    {
        $vendors = Vendor::all();

        return view('services.edit', compact('service','vendors'));
    }


    // Update service
    public function update(Request $request, Service $service)
    {

        $request->validate([
            'name' => 'required',
            'cost' => 'required|numeric'
        ]);

        $service->update([
            'vendor_id' => $request->vendor_id,
            'name' => $request->name,
            'cost' => $request->cost
        ]);

        return redirect()
            ->route('events.show', $service->event_id)
            ->with('success','Service updated successfully');
    }


    // Delete service
    public function destroy(Service $service)
    {
        $event_id = $service->event_id;

        $service->delete();

        return redirect()
            ->route('events.show', $event_id)
            ->with('success','Service deleted successfully');
    }
}