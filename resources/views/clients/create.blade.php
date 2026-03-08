<!DOCTYPE html>
<html>
<head>
<title>Add Client</title>
</head>

<body>

<h1>Add Client</h1>

@if ($errors->any())
<div style="color:red;">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="/clients">

@csrf

<label>Name</label>
<br>
<input type="text" name="name" required>
<br><br>

<label>Email</label>
<br>
<input type="email" name="email" required>
<br><br>

<label>Phone</label>
<br>
<input type="text" name="phone">
<br><br>

<button type="submit">Add Client</button>

</form>

<br>

<a href="/clients">Back</a>

</body>
</html>