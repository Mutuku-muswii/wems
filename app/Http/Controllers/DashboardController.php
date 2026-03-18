<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Event;
use App\Models\Vendor;
use App\Models\Attendee;

class DashboardController extends Controller
{

    public function index()
    {
        $clients = Client::count();
        $events = Event::count();
        $vendors = Vendor::count();
        $attendees = Attendee::count();

        $latestEvents = Event::latest()->take(5)->get();

        return view('dashboard', compact(
            'clients',
            'events',
            'vendors',
            'attendees',
            'latestEvents'
        ));
    }

}