<!DOCTYPE html>
<html>
<head>
<title>Add Attendee</title>
</head>

<body>

<h2>Add Attendee for {{ $event->title }}</h2>

<form method="POST" action="/events/{{ $event->id }}/attendees">

@csrf

<label>Name</label><br>
<input type="text" name="name" required>
<br><br>

<label>Email</label><br>
<input type="email" name="email" required>
<br><br>

<label>Phone</label><br>
<input type="text" name="phone">
<br><br>

<button type="submit">Add Attendee</button>

</form>

<br>

<a href="/events">Back to Events</a>

</body>
</html>