<h1>All Events</h1>

<a href="{{ route('events.create') }}">Create New Event</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Location</th>
        <th>Budget</th>
        <th>Actions</th>
    </tr>

    @foreach($events as $event)
    <tr>
        <td>{{ $event->title }}</td>
        <td>{{ $event->event_date }}</td>
        <td>{{ $event->location }}</td>
        <td>{{ $event->budget }}</td>
        <td>
            <a href="{{ route('events.edit', $event->id) }}">Edit</a>
<a href="{{ route('events.show', $event->id) }}">View</a>
            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>