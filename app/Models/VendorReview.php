<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'event_id',
        'reviewer_id',
        'reviewer_role',
        'punctuality',
        'quality',
        'communication',
        'value',
        'professionalism',
        'comment',
        'is_anonymous',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    // Calculate overall rating
    public function getOverallRatingAttribute()
    {
        return ($this->punctuality + $this->quality + $this->communication + $this->value + $this->professionalism) / 5;
    }
}