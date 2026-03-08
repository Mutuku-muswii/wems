<!DOCTYPE html>
<html>
<head>
<title>Clients</title>
</head>

<body>

<h1>Clients</h1>

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

<a href="/clients/create">Add Client</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
</tr>

@foreach($clients as $client)

<tr>

<td>{{ $client->name }}</td>
<td>{{ $client->email }}</td>
<td>{{ $client->phone }}</td>

</tr>

@endforeach

</table>

</body>
</html>