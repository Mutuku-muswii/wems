@extends('layouts.app')

@section('title', $vendor->name . ' - WEMS')
@section('page-title', 'Vendor Details')

@section('content')
<div class="mb-3">
    <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Vendors
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Vendor Info</h5>
            </div>
            <div class="card-body">
                <h4>{{ $vendor->name }}</h4>
                <span class="badge bg-info mb-2">{{ $vendor->service_type }}</span>
                
                <hr>
                
                <p><strong>Contact Person:</strong> {{ $vendor->contact ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $vendor->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $vendor->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $vendor->address ?? 'N/A' }}</p>
                
                <hr>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-primary">Edit Vendor</a>
                </div>
            </div>
        </div>
        
        <!-- Performance Stats -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Performance</h5>
            </div>
            <div class="card-body text-center">
                <h2 class="mb-0">{{ $vendor->services->count() }}</h2>
                <small class="text-muted">Total Services Provided</small>
                
                <hr>
                
                <h4 class="mb-0">KES {{ number_format($vendor->services->sum('cost'), 0) }}</h4>
                <small class="text-muted">Total Revenue</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Service History</h5>
            </div>
            <div class="card-body p-0">
                @if($vendor->services->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Event</th>
                                    <th>Service</th>
                                    <th>Cost</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendor->services as $service)
                                <tr>
                                    <td>{{ $service->event->title ?? 'N/A' }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>KES {{ number_format($service->cost, 2) }}</td>
                                    <td>{{ $service->event->event_date->format('M d, Y') ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <p>No services assigned to this vendor yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection