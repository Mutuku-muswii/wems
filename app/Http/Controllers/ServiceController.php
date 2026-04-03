<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Event;
use App\Models\Vendor;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['event', 'vendor'])->latest()->get();
        return view('services.index', compact('services'));
    }

    /**
     * UPDATED: Now fetches vendors so the dropdown works
     */
    public function create($event)
    {
        // 1. Fetch all vendors from the database
        $vendors = Vendor::all();

        // 2. Pass BOTH the event_id and the vendors list to the view
        return view('services.create', [
            'event_id' => $event,
            'vendors'  => $vendors
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        Service::create([
            'event_id' => $request->event_id,
            'vendor_id' => $request->vendor_id,
            'name' => $request->name,
            'cost' => $request->cost,
            'description' => $request->description
        ]);

        return redirect()->route('events.show', $request->event_id)->with('success', 'Service added successfully');
    }

    public function edit(Service $service)
    {
        $vendors = Vendor::all();
        return view('services.edit', compact('service', 'vendors'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'vendor_id' => 'nullable|exists:vendors,id',
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $service->update([
            'vendor_id' => $request->vendor_id,
            'name' => $request->name,
            'cost' => $request->cost,
            'description' => $request->description
        ]);

        return redirect()->route('events.show', $service->event_id)->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $event_id = $service->event_id;
        $service->delete();

        return redirect()->route('events.show', $event_id)->with('success', 'Service deleted successfully');
    }
}