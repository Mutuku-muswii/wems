@extends('layouts.app')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Waridi Events Management System</h2>

<div class="row mb-4">

<div class="col-md-3">
<div class="card shadow-sm p-3">
<h6>Total Clients</h6>
<h2>{{ $clients }}</h2>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm p-3">
<h6>Total Events</h6>
<h2>{{ $events }}</h2>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm p-3">
<h6>Total Vendors</h6>
<h2>{{ $vendors }}</h2>
</div>
</div>

<div class="col-md-3">
<div class="card shadow-sm p-3">
<h6>Total Attendees</h6>
<h2>{{ $attendees }}</h2>
</div>
</div>

</div>

<h4>Recent Events</h4>

<table class="table table-striped">

<tr>
<th>Name</th>
<th>Date</th>
<th>Location</th>
<th>Action</th>
</tr>

@foreach($latestEvents as $event)

<tr>

<td>{{ $event->name }}</td>
<td>{{ $event->event_date }}</td>
<td>{{ $event->location }}</td>

<td>

<a href="{{ route('events.show',$event->id) }}" class="btn btn-sm btn-primary">
View
</a>

</td>

</tr>

@endforeach

</table>

</div>

@endsection