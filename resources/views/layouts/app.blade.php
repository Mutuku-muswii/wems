<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Waridi Events Management System - Final Year Project">
    <meta name="author" content="Muswii Collins Mutuku, Reg No: 22/05989">
    <title>@yield('title', 'WEMS')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #858796;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
        }
        
        body {
            font-family: "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 0.9rem;
            background-color: #f8f9fc;
        }
        
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }
        
        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            transition: all 0.3s;
        }
        
        #sidebar-wrapper .sidebar-heading {
            padding: 1rem;
            font-size: 1.2rem;
            font-weight: 800;
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .role-badge-sidebar {
            text-align: center;
            padding: 0.5rem;
            margin: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .role-admin { background: #e74a3b; color: white; }
        .role-manager { background: #4e73df; color: white; }
        .role-staff { background: #36b9cc; color: white; }
        .role-client { background: #1cc88a; color: white; }
        .role-vendor { background: #f6c23e; color: black; }
        
        #sidebar-wrapper .list-group {
            width: 100%;
        }
        
        #sidebar-wrapper .list-group-item {
            background: transparent;
            color: rgba(255,255,255,0.8);
            border: none;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
        }
        
        #sidebar-wrapper .list-group-item:hover,
        #sidebar-wrapper .list-group-item.active {
            color: white;
            background: rgba(255,255,255,0.1);
        }
        
        #sidebar-wrapper .list-group-item i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }
        
        #page-content-wrapper {
            width: 100%;
            padding: 0;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,0.15);
            padding: 0.5rem 1rem;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            color: #5a5c69;
            font-size: 0.9rem;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: #858796;
        }
        
        .container-fluid {
            padding: 1.5rem;
        }
        
        .card {
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
        }
        
        .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
        .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
        .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
        .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
        .border-left-danger { border-left: 0.25rem solid #e74a3b !important; }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">
                <i class="bi bi-calendar-event"></i> WEMS
            </div>
            
            <!-- Role Display -->
            @php
                $roleClass = 'role-' . (Auth::user()->role ?? 'guest');
                $roleName = ucfirst(Auth::user()->role ?? 'Guest');
            @endphp
            <div class="role-badge-sidebar {{ $roleClass }}">
                <i class="bi {{ Auth::user()->role_icon ?? 'bi-person' }}"></i> {{ $roleName }}
            </div>
            
            <div class="list-group list-group-flush">
                @php $role = Auth::user()->role ?? 'guest'; @endphp
                
                {{-- All roles see dashboard --}}
                <a class="list-group-item {{ request()->routeIs('dashboard', 'client.dashboard', 'vendor.dashboard') ? 'active' : '' }}" 
                   href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                
                {{-- Admin, Manager, Staff only --}}
                @if(in_array($role, ['admin', 'manager', 'staff']))
                    <a class="list-group-item {{ request()->routeIs('clients.*') ? 'active' : '' }}" 
                       href="{{ route('clients.index') }}">
                        <i class="bi bi-people"></i> Clients
                    </a>
                    
                    <a class="list-group-item {{ request()->routeIs('events.*') ? 'active' : '' }}" 
                       href="{{ route('events.index') }}">
                        <i class="bi bi-calendar-check"></i> Events
                    </a>
                @endif
                
                {{-- Admin, Manager only --}}
                @if(in_array($role, ['admin', 'manager']))
                    <a class="list-group-item {{ request()->routeIs('vendors.*') ? 'active' : '' }}" 
                       href="{{ route('vendors.index') }}">
                        <i class="bi bi-shop"></i> Vendors
                    </a>
                @endif
                
                {{-- Admin only --}}
                @if($role === 'admin')
                    <a class="