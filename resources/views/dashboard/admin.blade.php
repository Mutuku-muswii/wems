@extends('layouts.app')

@section('title', 'Admin Dashboard - WEMS')
@section('page-title', 'System Administration')

@section('content')
<div class="alert alert-info">
    <i class="bi bi-shield-check me-2"></i>Welcome Administrator. You have full system access.
</div>

<div class="row g-4 mb-4">
    <div class="col-md-2">
        <div class="stat-card primary">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <h4 class="stat-number">{{ $stats['total_users'] }}</h4>
            <small>Users</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card success">
            <div class="stat-icon"><i class="bi bi-person-badge"></i></div>
            <h4 class="stat-number">{{ $stats['total_clients'] }}</h4>
            <small>Clients</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
            <h4 class="stat-number">{{ $stats['total_events'] }}</h4>
            <small>Events</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card info">
            <div class="stat-icon"><i class="bi bi-shop"></i></div>
            <h4 class="stat-number">{{ $stats['total_vendors'] }}</h4>
            <small>Vendors</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
            <h4 class="stat-number">KES {{ number_format($stats['total_revenue']/1000, 1) }}K</h4>
            <small>Revenue</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card secondary">
            <div class="stat-icon"><i class="bi bi-calendar-month"></i></div>
            <h4 class="stat-number">{{ $stats['events_this_month'] }}</h4>
            <small>This Month</small>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="content-card">
            <div class="content-card-header d-flex justify-content-between">
                <h5>Budget Alerts (>90% Used)</h5>
                <a href="{{ route('events.index') }}" class="btn btn-sm btn-primary">All Events</a>
            </div>
            <div class="content-card-body">
                @if($budget_alerts->count() > 0)
                    <table class="table table-sm">
                        @foreach($budget_alerts as $event)
                        <tr class="{{ $event->is_over_budget ? 'table-danger' : 'table-warning' }}">
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->client->name }}</td>
                            <td>
                                <div class="progress" style="width: 100px; height: 20px;">
                                    <div class="progress-bar bg-danger" style="width: {{ min($event->budget_usage_percent, 100) }}%">
                                        {{ number_format($event->budget_usage_percent, 0) }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <p class="text-muted text-center py-3">No budget alerts</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="content-card">
            <div class="content-card-header">
                <h5>Recent Users</h5>
            </div>
            <div class="content-card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($recent_users as $user)
                    <div class="list-group-item d-flex justify-content-between">
                        <div>
                            <h6 class="mb-0">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                        <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection