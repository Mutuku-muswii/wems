<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Event;
use App\Models\Vendor;
use App\Models\Attendee;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        
        return match($role) {
            'admin' => $this->adminDashboard(),
            'manager' => $this->managerDashboard(),
            'staff' => $this->staffDashboard(),
            'client' => redirect()->route('portal.dashboard'),
            'vendor' => redirect()->route('vendor.dashboard'),
            default => $this->staffDashboard(),
        };
    }

    private function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_clients' => Client::count(),
            'total_events' => Event::count(),
            'total_vendors' => Vendor::count(),
            'total_revenue' => Service::sum('cost'),
            'events_this_month' => Event::whereMonth('event_date', now()->month)->count(),
        ];

        $recent_events = Event::with('client')->latest()->take(10)->get();
        $recent_users = User::latest()->take(5)->get();
        
        // Budget alerts (over 90% spent)
        $budget_alerts = Event::with('services')
            ->get()
            ->filter(function($event) {
                $spent = $event->services->sum('cost');
                return $event->budget > 0 && ($spent / $event->budget) > 0.9;
            })
            ->take(5);

        return view('dashboard.admin', compact('stats', 'recent_events', 'recent_users', 'budget_alerts'));
    }

    private function managerDashboard()
    {
        $events = Event::with('client', 'services')
            ->whereIn('status', ['planning', 'confirmed', 'ongoing'])
            ->latest()
            ->get();

        $stats = [
            'active_events' => $events->count(),
            'pending_vendors' => Service::whereNull('vendor_id')->count(),
            'this_month_events' => Event::whereMonth('event_date', now()->month)->count(),
            'overdue_events' => Event::where('event_date', '<', now())->where('status', '!=', 'completed')->count(),
        ];

        // Budget alerts
        $budget_alerts = $events->filter(function($event) {
            return $event->is_over_budget || $event->budget_usage_percent > 80;
        })->take(5);

        $unassigned_vendors = Service::whereNull('vendor_id')->with('event')->take(5)->get();

        return view('dashboard.manager', compact('events', 'stats', 'budget_alerts', 'unassigned_vendors'));
    }

    
private function staffDashboard()
{
    // Staff sees events assigned to them OR events they created
    $my_events = Event::with('client')
        ->where(function($q) {
            $q->where('assigned_to', auth()->id())
              ->orWhere('user_id', auth()->id());
        })
        ->where('status', '!=', 'completed')
        ->whereDate('event_date', '>=', now())
        ->orderBy('event_date')
        ->take(10)
        ->get();

    $tasks = [
        'upcoming_events' => $my_events->count(),
        'attendees_this_week' => Attendee::whereHas('event', function($q) {
            $q->where('assigned_to', auth()->id())->orWhere('user_id', auth()->id());
        })->where('created_at', '>', now()->subDays(7))->count(),
        'services_this_week' => Service::whereHas('event', function($q) {
            $q->where('assigned_to', auth()->id())->orWhere('user_id', auth()->id());
        })->where('created_at', '>', now()->subDays(7))->count(),
    ];

    return view('dashboard.staff', compact('my_events', 'tasks'));
}

    public function reports()
    {
        // Admin only
        $monthly_revenue = Service::selectRaw('MONTH(created_at) as month, SUM(cost) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->get();

        $events_by_status = Event::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $top_vendors = Vendor::withCount('services')
            ->withSum('services', 'cost')
            ->orderByDesc('services_sum_cost')
            ->take(10)
            ->get();

        return view('dashboard.reports', compact('monthly_revenue', 'events_by_status', 'top_vendors'));
    }
}