<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'vendor_id',
        'name',
        'description',
        'cost',
        'status',
        'delivered_on_time',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'delivered_on_time' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}