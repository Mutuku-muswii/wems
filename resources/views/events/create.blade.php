<h1>Create Event</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('events.store') }}" method="POST">
    @csrf

    <label>Title:</label><br>
    <input type="text" name="title" value="{{ old('title') }}" required>
    <br><br>

    <label>Description:</label><br>
    <textarea name="description">{{ old('description') }}</textarea>
    <br><br>

    <label>Date:</label><br>
    <input type="date" name="event_date" value="{{ old('event_date') }}" required>
    <br><br>

    <label>Location:</label><br>
    <input type="text" name="location" value="{{ old('location') }}" required>
    <br><br>

    <label>Budget:</label><br>
    <input type="number" step="0.01" name="budget" value="{{ old('budget') }}">
    <br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <option value="planned">Planned</option>
        <option value="ongoing">Ongoing</option>
        <option value="completed">Completed</option>
    </select>
    <br><br>

    <button type="submit">Create Event</button>
</form>