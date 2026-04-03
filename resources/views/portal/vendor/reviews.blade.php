@extends('layouts.app')

@section('title', 'My Reviews - WEMS')
@section('page-title', 'My Performance Reviews')

@section('content')
<div class="mb-3">
    <a href="{{ route('vendor.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Client & Manager Feedback</h5>
    </div>
    <div class="card-body">
        @if($reviews->count() > 0)
            @foreach($reviews as $review)
            <div class="border-bottom pb-3 mb-3">
                <div class="d-flex justify-content-between">
                    <strong>{{ $review->event->title }}</strong>
                    <span class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->overall_rating)
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </span>
                </div>
                <p class="text-muted small">By {{ ucfirst($review->reviewer_role) }} | {{ $review->created_at->format('M d, Y') }}</p>
                <p>{{ $review->comment }}</p>
            </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="bi bi-star fs-1 text-muted"></i>
                <p class="mt-3 text-muted">No reviews yet. Reviews appear after event completion.</p>
            </div>
        @endif
    </div>
</div>
@endsection