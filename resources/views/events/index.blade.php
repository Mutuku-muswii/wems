@extends('layouts.app')

@section('title', 'Events - WEMS')
@section('page-title', 'Manage Events')

@section('content')
<div class="content-card">
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Events</h5>
        <a href="{{ route('events.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Create Event
        </a>
    </div>
    <div class="content-card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Budget</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->client->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                        <td>{{ $event->location }}</td>
                        <td>KES {{ number_format($event->budget, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $event->status === 'completed' ? 'success' : ($event->status === 'cancelled' ? 'danger' : ($event->status === 'ongoing' ? 'warning' : 'primary')) }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-info" title="Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No events found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection