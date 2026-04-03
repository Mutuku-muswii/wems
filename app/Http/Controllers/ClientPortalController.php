<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Client;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientPortalController extends Controller
{
    private function getClient()
    {
        return Client::findOrFail(auth()->user()->client_id);
    }

    public function dashboard()
    {
        $client = $this->getClient();
        
        $stats = [
            'total_events' => $client->events()->count(),
            'upcoming_events' => $client->events()->where('event_date', '>=', now())->where('status', '!=', 'cancelled')->count(),
            'completed_events' => $client->events()->where('status', 'completed')->count(),
            'total_attendees' => Attendee::whereHas('event', function($q) use ($client) {
                $q->where('client_id', $client->id);
            })->count(),
        ];

        $recent_events = $client->events()
            ->with('attendees')
            ->latest()
            ->take(5)
            ->get();

        return view('portal.client.dashboard', compact('client', 'stats', 'recent_events'));
    }

    public function events()
    {
        $client = $this->getClient();
        $events = $client->events()->with('attendees')->latest()->paginate(10);
        
        return view('portal.client.events', compact('events'));
    }

    public function eventDetails(Event $event)
    {
        $client = $this->getClient();
        
        if ($event->client_id !== $client->id) {
            abort(403);
        }

        $event->load(['services.vendor', 'attendees']);
        
        // Attendee stats
        $attendeeStats = [
            'total' => $event->attendees->count(),
            'confirmed' => $event->attendees->where('rsvp_status', 'confirmed')->count(),
            'pending' => $event->attendees->where('rsvp_status', 'pending')->count(),
            'declined' => $event->attendees->where('rsvp_status', 'declined')->count(),
        ];

        return view('portal.client.event-details', compact('event', 'attendeeStats'));
    }

    // CLIENT ADDS ATTENDEES - MANUAL ENTRY
    public function addAttendee(Request $request, Event $event)
    {
        $client = $this->getClient();
        
        if ($event->client_id !== $client->id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Attendee::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'rsvp_status' => 'pending',
            'access_token' => Attendee::generateToken(),
        ]);

        return back()->with('success', 'Attendee added successfully');
    }

    // CLIENT ADDS ATTENDEES - EXCEL UPLOAD
    public function uploadAttendees(Request $request, Event $event)
    {
        $client = $this->getClient();
        
        if ($event->client_id !== $client->id) {
            abort(403);
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);

        // Simple CSV parsing (you can use Maatwebsite/Laravel-Excel package for better handling)
        $file = $request->file('file');
        $path = $file->getRealPath();
        
        $handle = fopen($path, 'r');
        $header = fgetcsv($handle); // Skip header
        
        $added = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) >= 1 && !empty($row[0])) {
                try {
                    Attendee::create([
                        'event_id' => $event->id,
                        'name' => $row[0],
                        'email' => $row[1] ?? null,
                        'phone' => $row[2] ?? null,
                        'rsvp_status' => 'pending',
                        'access_token' => Attendee::generateToken(),
                    ]);
                    $added++;
                } catch (\Exception $e) {
                    $errors[] = "Error with {$row[0]}: " . $e->getMessage();
                }
            }
        }
        
        fclose($handle);

        $message = "Added {$added} attendees successfully.";
        if (!empty($errors)) {
            $message .= " " . count($errors) . " errors occurred.";
        }

        return back()->with('success', $message);
    }

    // CLIENT DELETES THEIR ATTENDEE
    public function deleteAttendee(Event $event, Attendee $attendee)
    {
        $client = $this->getClient();
        
        if ($event->client_id !== $client->id || $attendee->event_id !== $event->id) {
            abort(403);
        }

        $attendee->delete();
        return back()->with('success', 'Attendee removed');
    }

    
    public function invoices()
    {
        $client = $this->getClient();
        return view('portal.client.invoices', compact('client'));
    }

    public function approveEvent(Request $request, Event $event)
    {
        $client = $this->getClient();
        
        if ($event->client_id !== $client->id) {
            abort(403);
        }

        $event->update([
            'client_approved' => true,
            'client_approved_at' => now()
        ]);
        
        return back()->with('success', 'Event plan approved successfully');
    }
}