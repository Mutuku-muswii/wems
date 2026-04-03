@extends('layouts.app')

@section('title', 'Vendor Dashboard - WEMS')
@section('page-title', 'My Vendor Portal')

@section('content')
<div class="alert alert-info d-flex align-items-center mb-4">
    <i class="bi bi-shop me-3 fs-4"></i>
    <div>
        <strong>Welcome, {{ auth()->user()->vendor->name ?? 'Vendor' }}</strong><br>
        <small class="mb-0">View your assigned events and service requests</small>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center py-3">
            <div class="card-body">
                <i class="bi bi-calendar-check fs-1 text-primary mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_events'] }}</h3>
                <small class="text-muted">Total Events</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center py-3">
            <div class="card-body">
                <i class="bi bi-calendar-event fs-1 text-success mb-2"></i>
                <h3 class="mb-0">{{ $stats['active_events'] }}</h3>
                <small class="text-muted">Active Now</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center py-3">
            <div class="card-body">
                <i class="bi bi-cash-stack fs-1 text-warning mb-2"></i>
                <h3 class="mb-0">KES {{ number_format($stats['total_earnings'], 0) }}</h3>
                <small class="text-muted">Total Earnings</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 text-center py-3">
            <div class="card-body">
                <i class="bi bi-star-fill fs-1 text-info mb-2"></i>
                <h3 class="mb-0">{{ $stats['average_rating'] ?? 'N/A' }}</h3>
                <small class="text-muted">Avg Rating</small>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Recent Service Assignments</h5>
        <a href="{{ route('vendor.events') }}" class="btn btn-sm btn-primary">View All My Events</a>
    </div>
    <div class="card-body p-0">
        @if($recent_services->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Event</th>
                            <th>Client</th>
                            <th>Service</th>
                            <th>Cost</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_services as $service)
                        <tr>
                            <td class="ps-4">{{ $service->event->title }}</td>
                            <td>{{ $service->event->client->name ?? 'N/A' }}</td>
                            <td>{{ $service->name }}</td>
                            <td>KES {{ number_format($service->cost, 2) }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('vendor.events.show', $service->event) }}" class="btn btn-sm btn-primary">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-shop fs-1 text-muted"></i>
                <p class="mt-3 text-muted">No services assigned to you yet.<br>Event managers will assign you to events.</p>
            </div>
        @endif
    </div>
</div>
@endsection