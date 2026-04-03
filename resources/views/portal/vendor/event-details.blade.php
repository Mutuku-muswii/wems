@extends('layouts.app')

@section('title', 'Event Details - WEMS')
@section('page-title', 'Event: ' . $event->title)

@section('content')
<div class="mb-3">
    <a href="{{ route('vendor.events') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to My Events
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Event Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Title:</strong> {{ $event->title }}</p>
                <p><strong>Client:</strong> {{ $event->client->name ?? 'N/A' }}</p>
                <p><strong>Date:</strong> {{ $event->event_date->format('l, F d, Y') }}</p>
                <p><strong>Location:</strong> {{ $event->location }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $event->status === 'completed' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'primary') }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>My Services for This Event</h5>
            </div>
            <div class="card-body p-0">
                @if($my_services->count() > 0)
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($my_services as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td>KES {{ number_format($service->cost, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td>Total:</td>
                                <td>KES {{ number_format($my_services->sum('cost'), 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <p class="text-center py-3 text-muted">No services assigned.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection