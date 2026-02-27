<h1>Event Details</h1>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<p><strong>Title:</strong> {{ $event->title }}</p>
<p><strong>Description:</strong> {{ $event->description }}</p>
<p><strong>Date:</strong> {{ $event->event_date }}</p>
<p><strong>Location:</strong> {{ $event->location }}</p>
<p><strong>Budget:</strong> {{ $event->budget }}</p>
<p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>
<p><strong>Owner:</strong> {{ $event->user->name ?? 'N/A' }}</p>

<hr>

<h2>Attendees</h2>

<a href="{{ route('events.attendees.create', $event->id) }}">
    Add Attendee
</a>

@if($event->attendees->count())
    <ul>
        @foreach($event->attendees as $attendee)
            <li>
                {{ $attendee->name }} ({{ $attendee->email }})

                <form action="{{ route('events.attendees.destroy', [$event->id, $attendee->id]) }}"
                      method="POST"
                      style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Remove</button>
                </form>
            </li>
        @endforeach
    </ul>
@else
    <p>No attendees yet.</p>
@endif

<br>
<a href="{{ route('events.index') }}">Back to Events</a>