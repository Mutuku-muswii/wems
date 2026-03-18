@extends('layouts.app')

@section('content')

<div class="container">

<h2>{{ $event->name }}</h2>

<p><strong>Client:</strong> {{ $event->client->name ?? 'No Client' }}</p>
<p><strong>Date:</strong> {{ $event->event_date }}</p>
<p><strong>Location:</strong> {{ $event->location }}</p>

<hr>

<div class="row mb-4">

<div class="col-md-3">
<div class="card p-3">
<h6>Event Budget</h6>
<h4>{{ number_format($event->budget) }}</h4>
</div>
</div>

<div class="col-md-3">
<div class="card p-3">
<h6>Total Services</h6>
<h4>{{ number_format($totalServices) }}</h4>
</div>
</div>

<div class="col-md-3">
<div class="card p-3">
<h6>Remaining Budget</h6>
<h4>{{ number_format($remainingBudget) }}</h4>
</div>
</div>

<div class="col-md-3">
<div class="card p-3">
<h6>Budget Used</h6>
<h4>{{ number_format($budgetUsage,1) }}%</h4>
</div>
</div>

</div>


<div class="row mb-4">

<div class="col-md-6">
<div class="card p-3">
<h6>Attendees</h6>
<h3>{{ $attendeeCount }}</h3>
</div>
</div>

<div class="col-md-6">
<div class="card p-3">
<h6>Services</h6>
<h3>{{ $serviceCount }}</h3>
</div>
</div>

</div>

<hr>

<h4>Services</h4>

<a href="{{ route('services.create', $event->id) }}" class="btn btn-primary mb-2">
Add Service
</a>

<table class="table table-bordered">

<tr>
<th>Service</th>
<th>Vendor</th>
<th>Cost</th>
</tr>

@foreach($event->services as $service)

<tr>

<td>{{ $service->name }}</td>

<td>{{ $service->vendor->name ?? 'No Vendor' }}</td>

<td>{{ number_format($service->cost) }}</td>

</tr>

@endforeach

</table>


<hr>

<h4>Attendees</h4>

<a href="{{ route('attendees.create', $event->id) }}" class="btn btn-success mb-2">
Add Attendee
</a>

<table class="table table-bordered">

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

</div>

@endsection