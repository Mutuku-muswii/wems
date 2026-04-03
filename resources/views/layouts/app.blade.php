<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WEMS')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f5f6fa;
            font-family: 'Segoe UI', sans-serif;
        }
        
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            color: white;
            padding: 20px;
        }
        
        .sidebar h4 {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar i {
            margin-right: 10px;
        }
        
        .main-content {
            padding: 30px;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        
        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .navbar {
            background: white;
            border-radius: 12px;
            margin-bottom: 30px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h4><i class="bi bi-calendar-event"></i> WEMS</h4>
                <small class="d-block mb-4 text-white-50">Waridi Events</small>
                
                @php $role = auth()->user()->role ?? 'staff'; @endphp
                
                @if(in_array($role, ['admin', 'manager', 'staff']))
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>Dashboard
                    </a>
                    <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i>Events
                    </a>
                    <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>Clients
                    </a>
                @endif
                
                @if(in_array($role, ['admin', 'manager']))
                    <a href="{{ route('vendors.index') }}" class="{{ request()->routeIs('vendors.*') ? 'active' : '' }}">
                        <i class="bi bi-shop"></i>Vendors
                    </a>
                @endif
                
                @if($role === 'admin')
                    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-person-gear"></i>Users
                    </a>
                @endif
                
                @if($role === 'client')
                    <a href="{{ route('portal.dashboard') }}" class="{{ request()->routeIs('portal.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>My Dashboard
                    </a>
                    <a href="{{ route('portal.events') }}" class="{{ request()->routeIs('portal.events*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i>My Events
                    </a>
                @endif
                
                @if($role === 'vendor')
                    <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>My Dashboard
                    </a>
                    <a href="{{ route('vendor.events') }}" class="{{ request()->routeIs('vendor.events*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i>My Events
                    </a>
                @endif
                
                <hr class="border-secondary my-4">
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-white text-decoration-none p-0">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Top Bar -->
                <div class="navbar d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
                        <small class="text-muted">{{ now()->format('l, F d, Y') }}</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-3">{{ auth()->user()->name }}</span>
                        <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>