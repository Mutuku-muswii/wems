<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Event;
use Illuminate\Http\Request;

class ClientPortalController extends Controller
{
    private function getClient()
    {
        $clientId = auth()->user()->client_id;
        return Client::findOrFail($clientId);
    }

    public function dashboard()
    {
        $client = $this->getClient();
        
        $stats = [
            'total_events' => $client->events()->count(),
            'upcoming' => $client->events()->where('event_date', '>=', now())->count(),
            'completed' => $client->events()->where('status', 'completed')->count(),
        ];

        $events = $client->events()->with('services')->latest()->take(5)->get();
        
        return view('portal.dashboard', compact('client', 'stats', 'events'));
    }

    public function events()
    {
        $client = $this->getClient();
        $events = $client->events()->with('services')->latest()->paginate(10);
        
        return view('portal.events', compact('events'));
    }

    public function showEvent(Event $event)
    {
        $client = $this->getClient();
        
        // Security check - ensure client owns this event
        if ($event->client_id !== $client->id) {
            abort(403, 'You do not have access to this event.');
        }

        $event->load(['services.vendor', 'attendees']);
        $totalSpent = $event->services->sum('cost');
        $remaining = $event->budget - $totalSpent;

        return view('portal.event-details', compact('event', 'totalSpent', 'remaining'));
    }
}