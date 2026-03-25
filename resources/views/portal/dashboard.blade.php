@extends('layouts.app')

@section('title', 'My Account - WEMS')
@section('page-title', 'Client Portal')

@section('content')
<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Welcome to your client portal.</strong> You can view your events and track your budget here.
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow h-100 py-2" style="border-left: 4px solid #4e73df;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">My Events</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2" style="border-left: 4px solid #1cc88a;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Budget</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">KES 2,050,000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-left-warning shadow h-100 py-2" style="border-left: 4px solid #f6c23e;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Remaining</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">KES 1,245,000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">My Events</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Progress</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Johnson Wedding Reception</strong><br>
                            <small class="text-muted">Wedding Event</small>
                        </td>
                        <td>15 June 2024</td>
                        <td>Karen Country Club</td>
                        <td>
                            <div class="progress mb-2" style="height: 10px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 95%"></div>
                            </div>
                            <small class="text-danger">95% used (KES 45k remaining)</small>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm">View Details</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Kimani Wedding</strong><br>
                            <small class="text-muted">Garden Wedding</small>
                        </td>
                        <td>20 September 2024</td>
                        <td>Windsor Golf Hotel</td>
                        <td>
                            <div class="progress mb-2" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 15%"></div>
                            </div>
                            <small class="text-success">15% used (KES 1.2M remaining)</small>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm">View Details</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Invoices</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td>INV-001</td>
                        <td>Catering Deposit</td>
                        <td>KES 192,500</td>
                        <td><span class="badge bg-success">Paid</span></td>
                    </tr>
                    <tr>
                        <td>INV-002</td>
                        <td>Photography</td>
                        <td>KES 85,000</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Contact Support</h6>
            </div>
            <div class="card-body">
                <p><strong>Your Event Manager:</strong> Sarah Muthoni</p>
                <p><i class="bi bi-envelope"></i> sarah@waridievents.co.ke</p>
                <p><i class="bi bi-telephone"></i> +254 712 345 678</p>
            </div>
        </div>
    </div>
</div>
@endsection