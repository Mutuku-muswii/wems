<!DOCTYPE html>
<html>
<head>

<title>Waridi Events Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.sidebar{
width:220px;
height:100vh;
position:fixed;
background:#343a40;
padding-top:20px;
}

.sidebar a{
display:block;
color:white;
padding:12px;
text-decoration:none;
}

.sidebar a:hover{
background:#495057;
}

.content{
margin-left:240px;
padding:20px;
}

</style>

</head>

<body>

<div class="sidebar">

<h5 class="text-white text-center mb-4">WEMS</h5>

<a href="/dashboard">Dashboard</a>

<a href="/clients">Clients</a>

<a href="/events">Events</a>

<a href="/vendors">Vendors</a>

<a href="/users">Users</a>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="btn btn-danger w-100 mt-3">Logout</button>
</form>

</div>
<div class="content">

@yield('content')

</div>

</body>

</html>