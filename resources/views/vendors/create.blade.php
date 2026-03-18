@extends('layouts.app')

@section('content')

<div class="container">

<h2>Add Vendor</h2>

<form action="{{ route('vendors.store') }}" method="POST">

@csrf

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Company</label>
<input type="text" name="company" class="form-control">
</div>

<div class="mb-3">
<label>Category</label>
<input type="text" name="category" class="form-control" placeholder="Catering, Photography, DJ">
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="mb-3">
<label>Estimated Cost</label>
<input type="number" name="estimated_cost" class="form-control">
</div>

<button class="btn btn-success">Save Vendor</button>

</form>

</div>

@endsection