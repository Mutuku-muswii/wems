@extends('layouts.app')

@section('title', $event->title . ' - My Account')
@section('page-title', 'Event: ' . $event->title)

@section('content')
<div class="mb-3">
    <a href="{{ route('portal.events') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to My Events
    </a>
</div>

<!-- Event Header -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-{{ $event->status === 'completed' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'primary') }} me-2">
                        {{ ucfirst($event->status) }}
                    </span>
                    @if($event->client_approved)
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Approved</span>
                    @else
                        <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pending Approval</span>
                    @endif
                </div>
                <h4 class="mb-1">{{ $event->title }}</h4>
                <p class="text-muted mb-0">
                    <i class="bi bi-geo-alt me-1"></i>{{ $event->location }} | 
                    <i class="bi bi-calendar me-1"></i>{{ $event->event_date->format('l, F d, Y') }}
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @if(!$event->client_approved && $event->status === 'planning')
                    <form action="{{ route('portal.events.approve', $event) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Approve Event Plan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Budget Overview -->
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Budget Overview</h5>
            </div>
            <div class="card-body">
                <div class="row text-center mb-4">
                    <div class="col-4 border-end">
                        <small class="text-muted d-block">Total</small>
                        <h5 class="text-primary mb-0">KES {{ number_format($event->budget, 0) }}</h5>
                    </div>
                    <div class="col-4 border-end">
                        <small class="text-muted d-block">Spent</small>
                        <h5 class="{{ $event->is_over_budget ? 'text-danger' : 'text-success' }} mb-0">
                            KES {{ number_format($event->total_spent, 0) }}
                        </h5>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">{{ $event->remaining_budget >= 0 ? 'Left' : 'Over' }}</small>
                        <h5 class="{{ $event->remaining_budget >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                            KES {{ number_format(abs($event->remaining_budget), 0) }}
                        </h5>
                    </div>
                </div>
                
                <div class="progress mb-2" style="height: 25px;">
                    <div class="progress-bar bg-{{ $event->budget_status_color }}" style="width: {{ min($event->budget_usage_percent, 100) }}%">
                        {{ number_format($event->budget_usage_percent, 0) }}%
                    </div>
                </div>
                
                @if($event->is_over_budget)
                    <div class="alert alert-danger mb-0 mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Over budget by KES {{ number_format(abs($event->remaining_budget), 2) }}
                    </div>
                @elseif($event->budget_usage_percent > 80)
                    <div class="alert alert-warning mb-0 mt-3">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        Budget critically low
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Services -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Services</h5>
            </div>
            <div class="card-body p-0">
                @if($event->services->count() > 0)
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Service</th>
                                <th>Vendor</th>
                                <th class="text-end pe-3">Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->services as $service)
                            <tr>
                                <td class="ps-3">{{ $service->name }}</td>
                                <td>{{ $service->vendor->name ?? 'Not assigned' }}</td>
                                <td class="text-end pe-3">KES {{ number_format($service->cost, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="2" class="text-end ps-3">TOTAL:</td>
                                <td class="text-end pe-3">KES {{ number_format($event->total_spent, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="text-center py-4 text-muted">
                        <p class="mb-0">No services added yet.<br>Your event manager will add these.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Attendee Management -->
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0"><i class="bi bi-people me-2"></i>My Attendees</h5>
            <small class="text-muted">Manage your guest list</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-upload me-1"></i>Upload CSV
            </button>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAttendeeModal">
                <i class="bi bi-plus-lg me-1"></i>Add Guest
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <!-- Stats -->
        <div class="p-3 bg-light border-bottom">
            <div class="row text-center">
                <div class="col">
                    <h4 class="mb-0">{{ $event->attendees->count() }}</h4>
                    <small class="text-muted">Total</small>
                </div>
                <div class="col border-start">
                    <h4 class="mb-0 text-success">{{ $event->attendees->where('rsvp_status', 'confirmed')->count() }}</h4>
                    <small class="text-muted">Confirmed</small>
                </div>
                <div class="col border-start">
                    <h4 class="mb-0 text-warning">{{ $event->attendees->where('rsvp_status', 'pending')->count() }}</h4>
                    <small class="text-muted">Pending</small>
                </div>
                <div class="col border-start">
                    <h4 class="mb-0 text-danger">{{ $event->attendees->where('rsvp_status', 'declined')->count() }}</h4>
                    <small class="text-muted">Declined</small>
                </div>
            </div>
        </div>

        @if($event->attendees->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Guest</th>
                            <th>Contact</th>
                            <th>RSVP Status</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->attendees as $attendee)
                        <tr>
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                        <span class="text-primary fw-bold">{{ substr($attendee->name, 0, 1) }}</span>
                                    </div>
                                    <span>{{ $attendee->name }}</span>
                                </div>
                            </td>
                            <td>
                                <small>{{ $attendee->email ?? 'No email' }}<br>{{ $attendee->phone ?? 'No phone' }}</small>
                            </td>
                            <td>
                                @php
                                    $rsvpColors = ['pending' => 'secondary', 'confirmed' => 'success', 'declined' => 'danger'];
                                @endphp
                                <span class="badge bg-{{ $rsvpColors[$attendee->rsvp_status] }}">
                                    {{ ucfirst($attendee->rsvp_status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <form action="{{ route('portal.events.attendees.delete', [$event, $attendee]) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this guest?')">
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
            <div class="text-center py-5">
                <i class="bi bi-people fs-1 text-muted"></i>
                <p class="text-muted mt-3">No guests added yet.<br>Add your attendees manually or upload a CSV file.</p>
            </div>
        @endif
    </div>
</div>

<!-- Add Attendee Modal -->
<div class="modal fade" id="addAttendeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Guest</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('portal.events.attendees.add', $event) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Guest</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload CSV Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Guests (CSV)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('portal.events.attendees.upload', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <small>Format: Name, Email, Phone<br>One guest per line</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select CSV File</label>
                        <input type="file" name="file" class="form-control" accept=".csv,.xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection