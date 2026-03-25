@extends('layouts.app')

@section('title', 'Add Service - WEMS')
@section('page-title', 'Add Service to Event')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Service Details</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Event</label>
                        <input type="text" class="form-control" value="{{ $event->title }}" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Select Vendor <span class="text-danger">*</span></label>
                        <select name="vendor_id" class="form-select" required>
                            <option value="">-- Select Vendor --</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }} ({{ $vendor->service_type }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Service Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Catering, Photography" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Cost (KES) <span class="text-danger">*</span></label>
                        <input type="number" name="cost" class="form-control" placeholder="0.00" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('events.show', $event) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection