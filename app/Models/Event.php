<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'client_id',
        'event_date',
        'location',
        'budget',
        'description',
        'status',
        'user_id'
    ];

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}