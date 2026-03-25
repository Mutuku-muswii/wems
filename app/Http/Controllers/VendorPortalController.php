<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Service;
use Illuminate\Http\Request;

class VendorPortalController extends Controller
{
    private function getVendor()
    {
        $vendorId = auth()->user()->vendor_id;
        return Vendor::findOrFail($vendorId);
    }

    public function dashboard()
    {
        $vendor = $this->getVendor();
        
        $services = Service::where('vendor_id', $vendor->id)
            ->with('event')
            ->latest()
            ->get();

        $stats = [
            'total_bookings' => $services->count(),
            'active' => $services->where('event.status', '!=', 'completed')->count(),
            'completed' => $services->where('event.status', 'completed')->count(),
            'total_earnings' => $services->sum('cost'),
        ];

        return view('vendor.dashboard', compact('vendor', 'services', 'stats'));
    }

    public function bookings()
    {
        $vendor = $this->getVendor();
        
        $services = Service::where('vendor_id', $vendor->id)
            ->with(['event.client'])
            ->latest()
            ->paginate(10);

        return view('vendor.bookings', compact('services'));
    }
}