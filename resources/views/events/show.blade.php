<!DOCTYPE html>
<html>
<head>
<title>Event Details</title>
</head>

<body>

<h1>{{ $event->title }}</h1>

<p><strong>Client:</strong> {{ $event->client->name }}</p>

<p><strong>Date:</strong> {{ $event->event_date }}</p>

<p><strong>Location:</strong> {{ $event->location }}</p>

<p><strong>Status:</strong> {{ $event->status }}</p>

<p><strong>Description:</strong> {{ $event->description }}</p>

<hr>

<h2>Attendees</h2>

<a href="/events/{{ $event->id }}/attendees/create">
Add Attendee
</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
</tr>

@foreach($event->attendees as $attendee)

<tr>

<td>{{ $attendee->name }}</td>
<td>{{ $attendee->email }}</td>
<td>{{ $attendee->phone }}</td>

</tr>

@endforeach

</table>

<br>

<a href="/events">Back to Events</a>

</body>
</html>