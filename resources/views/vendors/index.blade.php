@extends('layouts.app')

@section('title', 'Vendors - WEMS')
@section('page-title', 'Vendor Directory')

@section('content')
<div class="content-card">
    <div class="content-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Approved Vendors</h5>
            <small class="text-muted">Trusted partners for event services</small>
        </div>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
        <a href="{{ route('vendors.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Add Vendor
        </a>
        @endif
    </div>
    <div class="content-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Vendor</th>
                        <th>Service Type</th>
                        <th>Contact</th>
                        <th>Performance</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendors as $vendor)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                    <i class="bi bi-shop text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $vendor->name }}</h6>
                                    <small class="text-muted">{{ $vendor->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-dark border">
                                {{ $vendor->service_type }}
                            </span>
                        </td>
                        <td>
                            <small>
                                {{ $vendor->contact }}<br>
                                {{ $vendor->phone }}
                            </small>
                        </td>
                        <td>
                            @if($vendor->average_rating)
                                <div class="d-flex align-items-center">
                                    <span class="text-warning me-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $vendor->average_rating)
                                                <i class="bi bi-star-fill small"></i>
                                            @else
                                                <i class="bi bi-star small"></i>
                                            @endif
                                        @endfor
                                    </span>
                                    <small class="text-muted">({{ $vendor->average_rating }})</small>
                                </div>
                                <small class="text-muted">{{ $vendor->events_count }} events completed</small>
                            @else
                                <small class="text-muted">No reviews yet</small>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                            <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this vendor?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-shop fs-1"></i>
                            <p class="mt-2">No vendors registered yet</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection