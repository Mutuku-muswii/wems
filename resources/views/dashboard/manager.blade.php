@extends('layouts.app')

@section('title', 'Manager Dashboard - WEMS')
@section('page-title', 'Event Management')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
            <h3 class="stat-number">{{ $stats['active_events'] }}</h3>
            <p class="stat-label">Active Events</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
            <h3 class="stat-number">{{ $stats['pending_vendors'] }}</h3>
            <p class="stat-label">Pending Vendors</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="stat-icon"><i class="bi bi-calendar-month"></i></div>
            <h3 class="stat-number">{{ $stats['this_month_events'] }}</h3>
            <p class="stat-label">This Month</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
            <h3 class="stat-number">{{ $stats['overdue_events'] }}</h3>
            <p class="stat-label">Overdue</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="content-card">
            <div class="content-card-header d-flex justify-content-between">
                <h5>Budget Alerts (>80%)</h5>
            </div>
            <div class="content-card-body">
                @if($budget_alerts->count() > 0)
                    @foreach($budget_alerts as $event)
                    <div class="alert {{ $event->is_over_budget ? 'alert-danger' : 'alert-warning' }} d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $event->title }}</strong><br>
                            <small>{{ $event->client->name }} | Used: {{ number_format($event->budget_usage_percent, 1) }}%</small>
                        </div>
                        <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-light">View</a>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3">No budget alerts</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="content-card">
            <div class="content-card-header d-flex justify-content-between">
                <h5>Unassigned Vendor Services</h5>
            </div>
            <div class="content-card-body">
                @if($unassigned_vendors->count() > 0)
                    @foreach($unassigned_vendors as $service)
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                        <div>
                            <strong>{{ $service->name }}</strong><br>
                            <small>Event: {{ $service->event->title }}</small>
                        </div>
                        <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-primary">Assign Vendor</a>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3">All services have vendors assigned</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="content-card mt-4">
    <div class="content-card-header">
        <h5>Active Events</h5>
    </div>
    <div class="content-card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Budget Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events->take(10) as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->client->name }}</td>
                    <td>{{ $event->event_date->format('M d, Y') }}</td>
                    <td>
                        @if($event->is_over_budget)
                            <span class="badge bg-danger">Over Budget</span>
                        @elseif($event->budget_usage_percent > 80)
                            <span class="badge bg-warning">Critical</span>
                        @else
                            <span class="badge bg-success">Good</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-primary">Manage</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection