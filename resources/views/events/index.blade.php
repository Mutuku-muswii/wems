@extends('layouts.app')

@section('content')

<h2>Events</h2>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<a href="/events/create" class="btn btn-primary mb-3">Create Event</a>

<table class="table table-bordered">

<thead>
<tr>
<th>Title</th>
<th>Client</th>
<th>Date</th>
<th>Location</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($events as $event)

<tr>

<td>{{ $event->title }}</td>

<td>{{ $event->client->name ?? '' }}</td>

<td>{{ $event->event_date }}</td>

<td>{{ $event->location }}</td>

<td>{{ $event->status }}</td>

<td>

<a href="/events/{{ $event->id }}" class="btn btn-sm btn-info">
View
</a>

<a href="/events/{{ $event->id }}/attendees/create" class="btn btn-sm btn-success">
Add Attendee
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

@endsection