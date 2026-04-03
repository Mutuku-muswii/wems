@extends('layouts.app')

@section('title', 'My Events - WEMS')
@section('page-title', 'My Assigned Events')

@section('content')
<div class="mb-3">
    <a href="{{ route('vendor.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Events I'm Assigned To</h5>
    </div>
    <div class="card-body p-0">
        @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Event</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>My Services</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        @php
                            $myServices = $event->services->where('vendor_id', auth()->user()->vendor_id);
                        @endphp
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->client->name ?? 'N/A' }}</td>
                            <td>{{ $event->event_date->format('M d, Y') }}</td>
                            <td>{{ $myServices->count() }}</td>
                            <td>
                                <a href="{{ route('vendor.events.show', $event) }}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $events->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x fs-1 text-muted"></i>
                <p class="mt-3 text-muted">No events assigned to you yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection