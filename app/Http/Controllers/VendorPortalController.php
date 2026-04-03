<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Vendor;
use App\Models\Service;
use Illuminate\Http\Request;

class VendorPortalController extends Controller
{
    private function getVendor()
    {
        return Vendor::findOrFail(auth()->user()->vendor_id);
    }

    public function dashboard()
    {
        $vendor = $this->getVendor();
        
        $stats = [
            'total_events' => $vendor->services()->distinct('event_id')->count(),
            'active_events' => $vendor->services()->whereHas('event', function($q) {
                $q->where('status', '!=', 'completed');
            })->distinct('event_id')->count(),
            'total_earnings' => $vendor->services()->sum('cost'),
            'average_rating' => $vendor->average_rating ?? 'N/A',
        ];

        $recent_services = $vendor->services()
            ->with('event.client')
            ->latest()
            ->take(5)
            ->get();

        return view('portal.vendor.dashboard', compact('vendor', 'stats', 'recent_services'));
}

    public function events()
    {
        $vendor = $this->getVendor();
        
        $event_ids = $vendor->services()->pluck('event_id')->unique();
        $events = Event::whereIn('id', $event_ids)
            ->with('client', 'services')
            ->latest()
            ->paginate(10);
        
        return view('portal.vendor.events', compact('events'));
    }

    public function eventDetails(Event $event)
    {
        $vendor = $this->getVendor();
        
        // Check if vendor has services for this event
        $has_services = $event->services()->where('vendor_id', $vendor->id)->exists();
        
        if (!$has_services) {
            abort(403);
        }

        $my_services = $event->services()->where('vendor_id', $vendor->id)->get();
        
        return view('portal.vendor.event-details', compact('event', 'my_services'));
    }

    public function myReviews()
    {
        $vendor = $this->getVendor();
        $reviews = $vendor->reviews()->with('event')->latest()->paginate(10);
        
        return view('portal.vendor.reviews', compact('vendor', 'reviews'));
    }
}