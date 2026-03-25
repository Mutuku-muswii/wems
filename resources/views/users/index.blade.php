@extends('layouts.app')

@section('title', 'Users - WEMS')
@section('page-title', 'Manage Users')

@section('content')
<div class="content-card">
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Users</h5>
        <a href="#" class="btn btn-primary" onclick="alert('User creation form')">
            <i class="bi bi-plus-lg me-2"></i>Add User
        </a>
    </div>
    <div class="content-card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users ?? [] as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $user->role ?? 'User' }}</span>
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No users found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection