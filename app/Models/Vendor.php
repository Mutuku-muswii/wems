<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'service_type',      // What they do: Catering, Sound, Decor, etc.
        'contact',         // Contact person name
        'email',
        'phone',
        'address',
        'standard_rate',   // Optional: Their typical starting price
        'notes',           // Additional info
    ];

    protected $casts = [
        'standard_rate' => 'decimal:2',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function reviews()
    {
        return $this->hasMany(VendorReview::class);
    }

    // Total earned from all events
    public function getTotalEarnedAttribute()
    {
        return $this->services()->sum('cost');
    }

    // Number of events worked
    public function getEventsCountAttribute()
    {
        return $this->services()->distinct('event_id')->count();
    }
}