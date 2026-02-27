<h1>Edit Event</h1>

<form action="{{ route('events.update', $event->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $event->title }}" required>
    <br><br>

    <input type="date" name="event_date" value="{{ $event->event_date }}" required>
    <br><br>

    <input type="text" name="location" value="{{ $event->location }}" required>
    <br><br>

    <input type="number" step="0.01" name="budget" value="{{ $event->budget }}">
    <br><br>

    <button type="submit">Update</button>
</form>