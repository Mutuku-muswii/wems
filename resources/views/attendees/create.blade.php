@extends('layouts.app')

@section('title', 'Add Attendee - WEMS')
@section('page-title', 'Add Attendee')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h4 class="mb-0">Add Attendee to {{ $event->title }}</h4>
                </div>
                <div class="content-card-body">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('attendees.store', $event->id) }}" method="POST">
                        @csrf
                        {{-- Hidden field to link the attendee to this specific event --}}
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Attendee Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="Enter full name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="example@email.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="+254...">
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Save Attendee
                            </button>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection