@extends('layouts.app')

@section('content')

<h2>Create Event</h2>

@if ($errors->any())
<div class="alert alert-danger">
<ul>

@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach

</ul>
</div>
@endif

<form method="POST" action="/events">

@csrf

<div class="mb-3">
<label class="form-label">Event Title</label>
<input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Client</label>

<select name="client_id" class="form-control" required>

<option value="">Select Client</option>

@foreach($clients as $client)

<option value="{{ $client->id }}">
{{ $client->name }}
</option>

@endforeach

</select>

</div>

<div class="mb-3">
<label class="form-label">Event Date</label>
<input type="date" name="event_date" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Location</label>
<input type="text" name="location" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Budget</label>
<input type="number" name="budget" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">Description</label>
<textarea name="description" class="form-control"></textarea>
</div>

<div class="mb-3">
<label class="form-label">Status</label>

<select name="status" class="form-control">
<option value="planned">Planned</option>
<option value="ongoing">Ongoing</option>
<option value="completed">Completed</option>
</select>

</div>

<button type="submit" class="btn btn-primary">
Create Event
</button>

</form>

@endsection