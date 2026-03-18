@extends('layouts.app')

@section('content')

<div class="container">

<h2>Vendors</h2>

<a href="{{ route('vendors.create') }}" class="btn btn-primary mb-3">Add Vendor</a>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<table class="table table-bordered">

<thead>
<tr>
<th>Name</th>
<th>Company</th>
<th>Category</th>
<th>Phone</th>
<th>Email</th>
<th>Estimated Cost</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($vendors as $vendor)

<tr>

<td>{{ $vendor->name }}</td>
<td>{{ $vendor->company }}</td>
<td>{{ $vendor->category }}</td>
<td>{{ $vendor->phone }}</td>
<td>{{ $vendor->email }}</td>
<td>{{ $vendor->estimated_cost }}</td>

<td>

<a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-warning btn-sm">Edit</a>

<form action="{{ route('vendors.destroy', $vendor->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">Delete</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection