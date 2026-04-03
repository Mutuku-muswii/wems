@extends('layouts.app')

@section('title', 'My Account - WEMS')
@section('page-title', 'Welcome, ' . $client->name)

@section('content')
<div class="alert alert-primary d-flex align-items-center mb-4">
    <i class="bi bi-shield-check me-3 fs-4"></i>
    <div>
        <strong>My Event Portal</strong><br>
        <small class="mb-0">Manage your events and guest lists</small>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center py-3 border-start border-4 border-primary">
            <div class="card-body">
                <i class="bi bi-calendar-check fs-1 text-primary mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_events'] }}</h3>
                <small class="text-muted">Total Events</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center py-3 border-start border-4 border-success">
            <div class="card-body">
                <i class="bi bi-calendar-event fs-1 text-success mb-2"></i>
                <h3 class="mb-0">{{ $stats['upcoming_events'] }}</h3>
                <small class="text-muted">Upcoming</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center py-3 border-start border-4 border-info">
            <div class="card-body">
                <i class="bi bi-check-circle fs-1 text-info mb-2"></i>
                <h3 class="mb-0">{{ $stats['completed_events'] }}</h3>
                <small class="text-muted">Completed</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center py-3 border-start border-4 border-warning">
            <div class="card-body">
                <i class="bi bi-people fs-1 text-warning mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_attendees'] }}</h3>
                <small class="text-muted">My Guests</small>
            </div>
        </div>
    </div>
</div>

<!-- Recent Events -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>My Recent Events</h5>
        <a href="{{ route('portal.events') }}" class="btn btn-primary btn-sm">View All Events</a>
    </div>
    <div class="card-body p-0">
        @if($recent_events->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Event</th>
                            <th>Date</th>
                            <th>Guests</th>
                            <th>Budget Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_events as $event)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @if($event->status === 'completed')
                                            <span class="badge bg-success rounded-pill"><i class="bi bi-check"></i></span>
                                        @elseif($event->status === 'cancelled')
                                            <span class="badge bg-danger rounded-pill"><i class="bi bi-x"></i></span>
                                        @else
                                            <span class="badge bg-primary rounded-pill"><i class="bi bi-hourglass"></i></span>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $event->title }}</h6>
                                        <small class="text-muted">{{ $event->location }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $event->event_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-people me-1"></i>{{ $event->attendees->count() }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $percent = $event->budget_usage_percent;
                                    $color = $percent < 80 ? 'success' : ($percent < 90 ? 'warning' : 'danger');
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px; width: 60px;">
                                        <div class="progress-bar bg-{{ $color }}" style="width: {{ min($percent, 100) }}%"></div>
                                    </div>
                                    <small class="text-{{ $color }}">{{ number_format($percent, 0) }}%</small>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('portal.events.show', $event) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>Details
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
                <p class="mt-3 text-muted">No events yet. Contact your event manager.</p>
            </div>
        @endif
    </div>
</div>
@endsection