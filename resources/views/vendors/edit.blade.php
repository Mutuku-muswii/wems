@extends('layouts.app')

@section('content')

<div class="container">

<h2>Edit Vendor</h2>

<form action="{{ route('vendors.update', $vendor->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control" value="{{ $vendor->name }}">
</div>

<div class="mb-3">
<label>Company</label>
<input type="text" name="company" class="form-control" value="{{ $vendor->company }}">
</div>

<div class="mb-3">
<label>Category</label>
<input type="text" name="category" class="form-control" value="{{ $vendor->category }}">
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control" value="{{ $vendor->phone }}">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" value="{{ $vendor->email }}">
</div>

<div class="mb-3">
<label>Estimated Cost</label>
<input type="number" name="estimated_cost" class="form-control" value="{{ $vendor->estimated_cost }}">
</div>

<button class="btn btn-primary">Update Vendor</button>

</form>

</div>

@endsection