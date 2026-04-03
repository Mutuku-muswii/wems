@extends('layouts.app')

@section('title', $client->name . ' - WEMS')
@section('page-title', 'Client Details')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="content-card">
            <div class="content-card-header">
                <h5 class="mb-0">Client Info</h5>
            </div>
            <div class="content-card-body">
                <p><strong>Name:</strong> {{ $client->name }}</p>
                <p><strong>Email:</strong> {{ $client->email }}</p>
                <p><strong>Phone:</strong> {{ $client->phone ?? 'N/A' }}</p>
                <hr>
                <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary w-100 mb-2">Edit Client</a>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary w-100">Back to List</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="content-card">
            <div class="content-card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Events ({{ $client->events->count() }})</h5>
                <a href="{{ route('events.create') }}?client_id={{ $client->id }}" class="btn btn-sm btn-primary">Create Event</a>
            </div>
            <div class="content-card-body">
                @if($client->events->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($client->events as $event)
                                <tr>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td>
                                        <span class="badge bg-{{ $event->status === 'completed' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'primary') }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">No events for this client yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection