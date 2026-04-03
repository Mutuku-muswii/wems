<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'rsvp_status',
        'access_token',
        'checked_in',
    ];

    protected $casts = [
        'checked_in' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Generate unique token for public access
    public static function generateToken()
    {
        return bin2hex(random_bytes(16));
    }
}