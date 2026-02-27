<h2>Add Attendee to: {{ $event->title }}</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('events.attendees.store', $event->id) }}" method="POST">
    @csrf

    <label>Name:</label><br>
    <input type="text" name="name" required>
    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required>
    <br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone">
    <br><br>

    <button type="submit">Add Attendee</button>
</form>