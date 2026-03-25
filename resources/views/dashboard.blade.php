@extends('layouts.app')

@section('title', 'Dashboard - WEMS')
@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Stats Cards - Clean but not overly polished -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow-sm h-100 py-2" style="border-left: 4px solid #4e73df;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Events</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEvents ?? 5 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-event fa-2x text-gray-300" style="font-size: 2rem; color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-success shadow-sm h-100 py-2" style="border-left: 4px solid #1cc88a;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Clients</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalClients ?? 4 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fa-2x text-gray-300" style="font-size: 2rem; color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-info shadow-sm h-100 py-2" style="border-left: 4px solid #36b9cc;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Vendors</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalVendors ?? 6 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-shop fa-2x text-gray-300" style="font-size: 2rem; color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-warning shadow-sm h-100 py-2" style="border-left: 4px solid #f6c23e;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Tasks</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check fa-2x text-gray-300" style="font-size: 2rem; color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Recent Events -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #f8f9fc; border-bottom: 1px solid #e3e6f0;">
                <h6 class="m-0 font-weight-bold text-primary">Recent Events</h6>
                <a href="{{ route('events.create') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Event Name</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Budget</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Johnson Wedding Reception</td>
                                <td>Johnson Family</td>
                                <td>15 Jun 2024</td>
                                <td>KES 850,000</td>
                                <td><span class="badge bg-success">Confirmed</span></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-circle btn-sm"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn btn-warning btn-circle btn-sm"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Safaricom 25th Anniversary</td>
                                <td>Safaricom PLC</td>
                                <td>20 Oct 2024</td>
                                <td>KES 2,500,000</td>
                                <td><span class="badge bg-primary">Planning</span></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-circle btn-sm"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn btn-warning btn-circle btn-sm"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Nairobi Chapel Conference</td>
                                <td>Nairobi Chapel</td>
                                <td>15 Aug 2024</td>
                                <td>KES 350,000</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                                <td>
                                    <a href="#" class="btn btn-info btn-circle btn-sm"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn btn-warning btn-circle btn-sm"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: #f8f9fc; border-bottom: 1px solid #e3e6f0;">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('events.create') }}" class="btn btn-primary btn-block w-100 mb-2">
                    <i class="bi bi-calendar-plus"></i> Create New Event
                </a>
                <a href="{{ route('clients.create') }}" class="btn btn-success btn-block w-100 mb-2">
                    <i class="bi bi-person-plus"></i> Add Client
                </a>
                <a href="{{ route('vendors.create') }}" class="btn btn-info btn-block w-100">
                    <i class="bi bi-shop"></i> Add Vendor
                </a>
            </div>
        </div>

        <!-- Budget Alert -->
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background: #f8f9fc; border-bottom: 1px solid #e3e6f0;">
                <h6 class="m