@extends('layouts.app')

@section('title', 'Add Attendee - WEMS')
@section('page-title', 'Add Attendee to Event')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Attendee Details</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('attendees.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Event</label>
                        <input type="text" class="form-control" value="{{ $event->title }}" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('events.show', $event) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Attendee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection