@extends('layouts.app')

@section('title', 'My Events - WEMS')
@section('page-title', 'My Events')

@section('content')
<div class="mb-3">
    <a href="{{ route('portal.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All My Events</h5>
    </div>
    <div class="card-body p-0">
        @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Event</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Attendees</th>
                            <th>Budget Status</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td class="ps-4">
                                <h6 class="mb-0">{{ $event->title }}</h6>
                            </td>
                            <td>{{ $event->event_date->format('M d, Y') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-people me-1"></i>{{ $event->attendees->count() }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $percent = $event->budget_usage_percent;
                                    $color = $percent < 80 ? 'success' : ($percent < 90 ? 'warning' : 'danger');
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px; width: 60px;">
                                        <div class="progress-bar bg-{{ $color }}" style="width: {{ min($percent, 100) }}%"></div>
                                    </div>
                                    <small class="text-{{ $color }}">{{ number_format($percent, 0) }}%</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $event->status === 'completed' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'primary') }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('portal.events.show', $event) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
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
                <p class="mt-3 text-muted">No events found. Contact your event manager.</p>
            </div>
        @endif
    </div>
</div>
@endsection