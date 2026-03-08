<!DOCTYPE html>
<html>
<head>
<title>Events</title>
</head>

<body>

<h1>Events</h1>

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

<a href="/events/create">Create Event</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
<th>Title</th>
<th>Client</th>
<th>Date</th>
<th>Location</th>
<th>Status</th>
<th>Actions</th>
</tr>

@foreach($events as $event)

<tr>

<td>{{ $event->title }}</td>

<td>{{ $event->client->name ?? '' }}</td>

<td>{{ $event->event_date }}</td>

<td>{{ $event->location }}</td>

<td>{{ $event->status }}</td>

<td>

<a href="/events/{{ $event->id }}">View</a>

|

<a href="/events/{{ $event->id }}/attendees/create">
Add Attendee
</a>

|

<form action="/events/{{ $event->id }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')
<button type="submit">Delete</button>
</form>

</td>

</tr>

@endforeach

</table>

</body>
</html>