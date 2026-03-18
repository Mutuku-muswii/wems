@extends('layouts.app')

@section('content')

<h2>Edit User</h2>

<form method="POST" action="{{ route('users.update',$user->id) }}">

@csrf
@method('PUT')

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" value="{{ $user->name }}" class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" value="{{ $user->email }}" class="form-control">
</div>

<div class="mb-3">
<label>Role</label>

<select name="role" class="form-control">

<option value="admin" {{ $user->role=='admin'?'selected':'' }}>
Admin
</option>

<option value="staff" {{ $user->role=='staff'?'selected':'' }}>
Staff
</option>

</select>

</div>

<button class="btn btn-success">Update</button>

</form>

@endsection