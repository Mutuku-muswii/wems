@extends('layouts.app')

@section('title', $event->title . ' - WEMS')
@section('page-title', 'Event Details')

@section('content')
<!-- Event Header -->
<div class="content-card mb-4">
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1">{{ $event->title }}</h4>
            <small class="text-muted">
                <i class="bi bi-person me-1"></i>{{ $event->client->name ?? 'No Client' }} | 
                <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($event->event_date)->format('l, F d, Y') }} | 
                <i class="bi bi-geo-alt me-1"></i>{{ $event->location }}
            </small>
        </div>
        <div>
            <span class="badge bg-{{ $event->status === 'completed' ? 'success' : ($event->status === 'cancelled' ? 'danger' : ($event->status === 'ongoing' ? 'warning' : 'primary')) }} fs-6">
                {{ ucfirst($event->status) }}
            </span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Budget Overview -->
    <div class="col-md-4">
        <div class="content-card h-100">
            <div class="content-card-header">
                <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Budget Overview</h5>
            </div>
            <div class="content-card-body">
                <div class="mb-3">
                    <small class="text-muted">Total Budget</small>
                    <h4 class="text-primary">KES {{ number_format($event->budget, 2) }}</h4>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Total Spent (Services)</small>
                    <h4 class="text-danger">KES {{ number_format($totalServices, 2) }}</h4>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <small class="text-muted">{{ $remainingBudget >= 0 ? 'Remaining Budget' : 'Over Budget' }}</small>
                    <h4 class="{{ $remainingBudget >= 0 ? 'text-success' : 'text-danger' }}">
                        KES {{ number_format(abs($remainingBudget), 2) }}
                    </h4>
                </div>
                
                @if($event->budget > 0)
                <div class="progress mb-2" style="height: 25px;">
                    <div class="progress-bar {{ $budgetUsage > 100 ? 'bg-danger' : ($budgetUsage > 80 ? 'bg-warning' : 'bg-success') }}" 
                         role="progressbar" 
                         style="width: {{ min($budgetUsage, 100) }}%">
                        {{ number_format($budgetUsage, 1) }}%
                    </div>
                </div>
                <small class="text-muted">{{ number_format($budgetUsage, 1) }}% of budget used</small>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-md-4">
        <div class="content-card h-100">
            <div class="content-card-header">
                <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Event Stats</h5>
            </div>
            <div class="content-card-body">
                <div class="row text-center">
                    <div class="col-6 mb-4">
                        <div class="stat-icon bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <h4>{{ $attendeeCount }}</h4>
                        <small class="text-muted">Attendees</small>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                            <i class="bi bi-tools"></i>
                        </div>
                        <h4>{{ $serviceCount }}</h4>
                        <small class="text-muted">Services</small>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('attendees.create', ['event' => $event->id]) }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-plus me-2"></i>Add Attendee
                    </a>
                    <a href="{{ route('services.create', $event) }}" class="btn btn-outline-success">
                        <i class="bi bi-plus-lg me-2"></i>Add Service
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Info -->
    <div class="col-md-4">
        <div class="content-card h-100">
            <div class="content-card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Event Info</h5>
            </div>
            <div class="content-card-body">
                <p><strong>Description:</strong></p>
                <p class="text-muted">{{ $event->description ?? 'No description provided' }}</p>
                
                <hr>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Event
                    </a>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services Section -->
<div class="content-card mt-4">
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Services ({{ $serviceCount }})</h5>
        <a href="{{ route('services.create', $event) }}" class="btn btn-sm btn-success">
            <i class="bi bi-plus-lg me-1"></i>Add Service
        </a>
    </div>
    <div class="content-card-body p-0">
        @if($event->services->count() > 0)
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Vendor</th>
                            <th>Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->vendor->name ?? 'No Vendor' }}</td>
                            <td>KES {{ number_format($service->cost, 2) }}</td>
                            <td>
                                <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-group-divider">
                        <tr class="table-active">
                            <th colspan="2" class="text-end">Total:</th>
                            <th colspan="2">KES {{ number_format($totalServices, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <i class="bi bi-tools fs-1"></i>
                <p class="mt-2">No services added yet</p>
                <a href="{{ route('services.create', $event) }}" class="btn btn-sm btn-primary">Add First Service</a>
            </div>
        @endif
    </div>
</div>

<!-- Attendees Section -->
<div class="content-card mt-4">
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-people me-2"></i>Attendees ({{ $attendeeCount }})</h5>
        <a href="{{ route('attendees.create', ['event' => $event->id]) }}" class="btn btn-sm btn-primary">
    
            <i class="bi bi-person-plus me-1"></i>Add Attendee
        </a>
    </div>
    <div class="content-card-body p-0">
        @if($event->attendees->count() > 0)
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->attendees as $attendee)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $attendee->name }}</td>
                            <td>{{ $attendee->email ?? 'N/A' }}</td>
                            <td>{{ $attendee->phone ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('attendees.edit', $attendee) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('attendees.destroy', $attendee) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this attendee?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <i class="bi bi-people fs-1"></i>
                <p class="mt-2">No attendees added yet</p>
                <a href="{{ route('attendees.create', ['event' => $event->id]) }}" class="btn btn-sm btn-primary">Add First Attendee</a>
            </div>
        @endif
    </div>
</div>
@endsection