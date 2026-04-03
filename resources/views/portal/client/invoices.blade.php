@extends('layouts.app')

@section('title', 'My Invoices - WEMS')
@section('page-title', 'My Invoices')

@section('content')
<div class="mb-3">
    <a href="{{ route('portal.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Invoices</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Invoice management coming soon. Contact your event manager for current invoices.
        </div>
    </div>
</div>
@endsection