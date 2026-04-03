@extends('layouts.app')

@section('content')

<div class="container">

<h2>Add Service</h2>

<form action="{{ route('services.store', $event_id) }}" method="POST">

@csrf

<input type="hidden" name="event_id" value="{{ $event_id }}">

<div class="mb-3">
<label>Service Name</label>
<input type="text" name="name" class="form-control" placeholder="Catering, Photography, DJ" required>
</div>

<div class="mb-3">
<label>Select Vendor</label>
<select name="vendor_id" class="form-control">

<option value="">Select Vendor</option>

@foreach($vendors as $vendor)

<option value="{{ $vendor->id }}">
{{ $vendor->name }} ({{ $vendor->category }})
</option>

@endforeach

</select>
</div>

<div class="mb-3">
<label>Service Cost</label>
<input type="number" name="cost" class="form-control" required>
</div>

<button class="btn btn-success">
Save Service
</button>

</form>

</div>

@endsection