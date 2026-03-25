@extends('layouts.app')

@section('title', $event->title . ' - WEMS')
@section('page-title', 'Event Details')

@section('content')
<!-- Event Header -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="m-0 font-weight-bold text-primary">{{ $event->title }}</h4>
            <small class="text-muted">
                <i class="bi bi-person"></i> {{ $event->client->name ?? 'No Client' }} | 
                <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('l, F d, Y') }} | 
                <i class="bi bi-geo-alt"></i> {{ $event->location }}
            </small>
        </div>
        <div>
            @php
                $statusColors = [
                    'planning' => 'primary',
                    'confirmed' => 'success',
                    'ongoing' => 'warning',
                    'completed' => 'info',
                    'cancelled' => 'danger'
                ];
                $currentPhase = match($event->status) {
                    'planning' => 'Pre-Event Phase',
                    'confirmed' => 'Pre-Event Phase',
                    'ongoing' => 'Event Day Phase',
                    'completed' => 'Post-Event Phase',
                    'cancelled' => 'Cancelled',
                    default => 'Unknown'
                };
            @endphp
            <span class="badge bg-{{ $statusColors[$event->status] ?? 'secondary' }} fs-6">{{ ucfirst($event->status) }}</span>
        </div>
    </div>
</div>

<!-- Event Phase Indicator -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="p-3 {{ in_array($event->status, ['planning', 'confirmed', 'ongoing', 'completed']) ? 'bg-primary text-white' : 'bg-light' }} rounded">
                    <i class="bi bi-clipboard-check fs-3"></i>
                    <h6 class="mt-2">1. Planning</h6>
                    <small>Budget & Vendors</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 {{ in_array($event->status, ['confirmed', 'ongoing', 'completed']) ? 'bg-success text-white' : 'bg-light' }} rounded">
                    <i class="bi bi-check-circle fs-3"></i>
                    <h6 class="mt-2">2. Confirmed</h6>
                    <small>Contracts Signed</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 {{ in_array($event->status, ['ongoing', 'completed']) ? 'bg-warning text-dark' : 'bg-light' }} rounded">
                    <i class="bi bi-calendar-event fs-3"></i>
                    <h6 class="mt-2">3. Event Day</h6>
                    <small>Execution</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 {{ $event->status === 'completed' ? 'bg-info text-white' : 'bg-light' }} rounded">
                    <i class="bi bi-file-text fs-3"></i>
                    <h6 class="mt-2">4. Post-Event</h6>
                    <small>Review & Pay</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Budget Overview -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Budget Overview</h6>
            </div>
            <div class="card-body">
                @php
                    $totalSpent = $event->services->sum('cost');
                    $remaining = $event->budget - $totalSpent;
                    $percentage = $event->budget > 0 ? ($totalSpent / $event->budget) * 100 : 0;
                @endphp
                
                <div class="text-center mb-3">
                    <small class="text-muted">Total Budget</small>
                    <h4 class="text-primary">KES {{ number_format($event->budget, 2) }}</h4>
                </div>
                
                <div class="text-center mb-3">
                    <small class="text-muted">Total Spent</small>
                    <h4 class="text-danger">KES {{ number_format($totalSpent, 2) }}</h4>
                </div>
                
                <hr>
                
                <div class="text-center mb-3">
                    <small class="text-muted">{{ $remaining >= 0 ? 'Remaining' : 'Over Budget' }}</small>
                    <h4 class="{{ $remaining >= 0 ? 'text-success' : 'text-danger' }}">
                        KES {{ number_format(abs($remaining), 2) }}
                    </h4>
                </div>
                
                <div class="progress mb-2" style="height: 25px;">
                    <div class="progress-bar {{ $percentage > 90 ? 'bg-danger' : ($percentage > 70 ? 'bg-warning' : 'bg-success') }}" 
                         role="progressbar" 
                         style="width: {{ min($percentage, 100) }}%">
                        {{ number_format($percentage, 0) }}%
                    </div>
                </div>
                
                @if($percentage > 90)
                    <div class="alert alert-danger mt-3 mb-0">
                        <i class="bi bi-exclamation-triangle"></i> Budget critical!
                    </div>
                @elseif($percentage > 70)
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="bi bi-info-circle"></i> Approaching limit
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                @if($event->status !== 'completed' && $event->status !== 'cancelled')
                    <a href="{{ route('services.create', $event) }}" class="btn btn-success w-100 mb-2">
                        <i class="bi bi-plus-lg"></i> Add Service
                    </a>
                    <a href="{{ route('attendees.create', $event) }}" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-person-plus"></i> Add Attendee
                    </a>
                @endif
                
                @if($event->status === 'planning')
                    <form action="{{ route('events.update', $event) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $event->title }}">
                        <input type="hidden" name="client_id" value="{{ $event->client_id }}">
                        <input type="hidden" name="event_date" value="{{ $event->event_date }}">
                        <input type="hidden" name="location" value="{{ $event->location }}">
                        <input type="hidden" name="budget" value="{{ $event->budget }}">
                        <input type="hidden" name="description" value="{{ $event->description }}">
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-check-circle"></i> Confirm Event
                        </button>
                    </form>
                @elseif($event->status === 'confirmed')
                    <form action="{{ route('events.update', $event) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $event->title }}">
                        <input type="hidden" name="client_id" value="{{ $event->client_id }}">
                        <input type="hidden" name="event_date" value="{{ $event->event_date }}">
                        <input type="hidden" name="location" value="{{ $event->location }}">
                        <input type="hidden" name="budget" value="{{ $event->budget }}">
                        <input type="hidden" name="description" value="{{ $event->description }}">
                        <input type="hidden" name="status" value="ongoing">
                        <button type="submit" class="btn btn-info w-100">
                            <i class="bi bi-play-circle"></i> Start Event Day
                        </button>
                    </form>
                @elseif($event->status === 'ongoing')
                    <form action="{{ route('events.update', $event) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $event->title }}">
                        <input type="hidden" name="client_id" value="{{ $event->client_id }}">
                        <input type="hidden" name="event_date" value="{{ $event->event_date }}">
                        <input type="hidden" name="location" value="{{ $event->location }}">
                        <input type="hidden" name="budget" value="{{ $event->budget }}">
                        <input type="hidden" name="description" value="{{ $event->description }}">
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="bi bi-check-all"></i> Complete Event
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Services -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Services & Vendors</h6>
                <span class="badge bg-primary">{{ $event->services->count() }} Services</span>
            </div>
            <div class="card-body">
                @if($event->services->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Vendor</th>
                                    <th>Cost</th>
                                    <th>Status</th>
                                    @if($event->status !== 'completed')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->services as $service)
                                    <tr>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->vendor->name ?? 'No Vendor' }}</td>
                                        <td>KES {{ number_format($service->cost, 2) }}</td>
                                        <td>
                                            @if($event->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($event->status === 'ongoing')
                                                <span class="badge bg-warning">In Progress</span>
                                            @else
                                                <span class="badge bg-info">Scheduled</span>
                                            @endif
                                        </td>
                                        @if($event->status !== 'completed')
                                            <td>
                                                <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-group-divider">
                                <tr class="table-active">
                                    <th colspan="2" class="text-end">Total:</th>
                                    <th colspan="{{ $event->status !== 'completed' ? '3' : '2' }}">KES {{ number_format($totalSpent, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-tools fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">No services added yet.</p>
                        @if($event->status !== 'completed' && $event->status !== 'cancelled')
                            <a href="{{ route('services.create', $event) }}" class="btn btn-primary">Add First Service</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Attendees -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Attendees</h6>
                <span class="badge bg-info">{{ $event->attendees->count() }} Registered</span>
            </div>
            <div class="card-body">
                @if($event->attendees->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    @if($event->status !== 'completed')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->attendees as $attendee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attendee->name }}</td>
                                        <td>{{ $attendee->email ?? 'N/A' }}</td>
                                        <td>{{ $attendee->phone ?? 'N/A' }}</td>
                                        @if($event->status !== 'completed')
                                            <td>
                                                <form action="{{ route('attendees.destroy', $attendee) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this attendee?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-people fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">No attendees registered yet.</p>
                        @if($event->status !== 'completed' && $event->status !== 'cancelled')
                            <a href="{{ route('attendees.create', $event) }}" class="btn btn-primary">Add First Attendee</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Post-Event Review (Only shows when completed) -->
        @if($event->status === 'completed')
            <div class="card shadow mb-4 border-left-info" style="border-left: 4px solid #36b9cc;">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold"><i class="bi bi-file-text"></i> Post-Event Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Event Outcome</h6>
                            <p><strong>Status:</strong> <span class="badge bg-success">Successfully Completed</span></p>
                            <p><strong>Total Budget:</strong> KES {{ number_format($event->budget, 2) }}</p>
                            <p><strong>Total Spent:</strong> KES {{ number_format($totalSpent, 2) }}</p>
                            <p><strong>Variance:</strong> 
                                <span class="{{ $remaining >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $remaining >= 0 ? 'Under budget by' : 'Over budget by' }} KES {{ number_format(abs($remaining), 2) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Key Metrics</h6>
                            <p><strong>Services Delivered:</strong> {{ $event->services->count() }}</p>
                            <p><strong>Attendees:</strong> {{ $event->attendees->count() }}</p>
                            <p><strong>Vendors Used:</strong> {{ $event->services->pluck('vendor_id')->unique()->count() }}</p>
                            
                            <div class="mt-3">
                                <button class="btn btn-primary btn-sm">
                                    <i class="bi bi-download"></i> Download Report
                                </button>
                                <button class="btn btn-success btn-sm">
                                    <i class="bi bi-envelope"></i> Send Feedback
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection