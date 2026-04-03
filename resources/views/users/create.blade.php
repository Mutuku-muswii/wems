@extends('layouts.app')

@section('title', 'Create User - WEMS')
@section('page-title', 'Create New User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" id="roleSelect" class="form-select @error('role') is-invalid @enderror" required onchange="toggleRoleFields()">
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client (Portal User)</option>
                                <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor (Portal User)</option>
                            </select>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Client Selection (shown when role is client) -->
                    <div class="mb-3" id="clientField" style="display: none;">
                        <label class="form-label">Link to Client <span class="text-danger">*</span></label>
                        <select name="client_id" class="form-select @error('client_id') is-invalid @enderror">
                            <option value="">Select Client</option>
                            @foreach(\App\Models\Client::all() as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} ({{ $client->email }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Client users can only see their own events</small>
                        @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Vendor Selection (shown when role is vendor) -->
                    <div class="mb-3" id="vendorField" style="display: none;">
                        <label class="form-label">Link to Vendor <span class="text-danger">*</span></label>
                        <select name="vendor_id" class="form-select @error('vendor_id') is-invalid @enderror">
                            <option value="">Select Vendor</option>
                            @foreach(\App\Models\Vendor::all() as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }} - {{ $vendor->service_type }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Vendor users can see events they're assigned to</small>
                        @error('vendor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleRoleFields() {
    const role = document.getElementById('roleSelect').value;
    const clientField = document.getElementById('clientField');
    const vendorField = document.getElementById('vendorField');
    
    // Hide all first
    clientField.style.display = 'none';
    vendorField.style.display = 'none';
    
    // Show relevant field
    if (role === 'client') {
        clientField.style.display = 'block';
    } else if (role === 'vendor') {
        vendorField.style.display = 'block';
    }
}

// Run on page load
toggleRoleFields();
</script>
@endsection