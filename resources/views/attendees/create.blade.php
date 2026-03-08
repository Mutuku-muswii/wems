<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
</head>

<body>

<h1>Create Event</h1>

@if ($errors->any())
<div style="color:red;">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="/events">

@csrf

<label>Event Title</label>
<br>
<input type="text" name="title" required>
<br><br>

<label>Client</label>
<br>
<select name="client_id" required>

<option value="">Select Client</option>

@foreach($clients as $client)

<option value="{{ $client->id }}">
{{ $client->name }}
</option>

@endforeach

</select>
<br><br>

<label>Event Date</label>
<br>
<input type="date" name="event_date" required>
<br><br>

<label>Location</label>
<br>
<input type="text" name="location" required>
<br><br>

<label>Budget</label>
<br>
<input type="number" name="budget">
<br><br>

<label>Description</label>
<br>
<textarea name="description"></textarea>
<br><br>

<label>Status</label>
<br>
<select name="status">

<option value="planned">Planned</option>
<option value="ongoing">Ongoing</option>
<option value="completed">Completed</option>

</select>

<br><br>

<button type="submit">Create Event</button>

</form>

<br>

<a href="/events">Back to Events</a>

</body>
</html>