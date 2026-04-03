@extends('layouts.app')

@section('title', 'Staff Dashboard - WEMS')
@section('page-title', 'My Work Dashboard')

@section('content')
<!-- Welcome -->
<div class="alert alert-info d-flex align-items-center mb-4">
    <i class="bi bi-person-workspace me-3 fs-4"></i>
    <div>
        <strong>Welcome, {{ auth()->user()->name }}</strong><br>
        <small class="mb-0">Manage your assigned events and tasks</small>
    </div>
</div>

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-primary bg-opacity-10">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-primary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-calendar-event fs-2 text-primary"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">{{ $tasks['upcoming_events'] }}</h3>
                    <small class="text-muted">My Active Events</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-success bg-opacity-10">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-success bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-plus fs-2 text-success"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">{{ $tasks['attendees_this_week'] }}</h3>
                    <small class="text-muted">Attendees Added This Week</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-info bg-opacity-10">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="bg-info bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-tools fs-2 text-info"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="mb-0">{{ $tasks['services_this_week'] }}</h3>
                    <small class="text-muted">Services Added This Week</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <a href="{{ route('clients.create') }}" class="btn btn-outline-primary w-100 py-3">
                    <i class="bi bi-person-plus fs-3 d-block mb-2"></i>
                    Add Client
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('events.create') }}" class="btn btn-outline-success w-100 py-3">
                    <i class="bi bi-calendar-plus fs-3 d-block mb-2"></i>
                    Create Event
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('events.index') }}" class="btn btn-outline-info w-100 py-3">
                    <i class="bi bi-list-check fs-3 d-block mb-2"></i>
                    View All Events
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('clients.index') }}" class="btn btn-outline-warning w-100 py-3">
                    <i class="bi bi-people fs-3 d-block mb-2"></i>
                    View Clients
                </a>
            </div>
        </div>
    </div>
</div>

<!-- My Events -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>My Upcoming Events</h5>
        <a href="{{ route('events.index') }}" class="btn btn-sm btn-primary">View All</a>
    </div>
    <div class="card-body p-0">
        @if($my_events->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Event</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($my_events as $event)
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0">{{ $event->title }}</h6>
                                <small class="text-muted">{{ $event->location }}</small>
                            </td>
                            <td>{{ $event->client->name ?? 'N/A' }}</td>
                            <td>{{ $event->event_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $event->status === 'completed' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'primary') }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('attendees.create', $event) }}" class="btn btn-sm btn-outline-primary me-1" title="Add Attendee">
                                    <i class="bi bi-person-plus"></i>
                                </a>
                                <a href="{{ route('services.create', $event) }}" class="btn btn-sm btn-outline-success me-1" title="Add Service">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                                <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-primary" title="View Event">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x fs-1 text-muted"></i>
                <p class="mt-3 text-muted">No upcoming events assigned to you.<br>Contact your manager for event assignments.</p>
            </div>
        @endif
    </div>
</div>
@endsection