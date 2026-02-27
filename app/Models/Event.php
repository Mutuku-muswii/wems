<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
    'title',
    'event_date',
    'location',
    'budget',
    'description',
    'status',
    'user_id'
];

public function user()
{
    return $this->belongsTo(User::class);
}
public function attendees()
{
    return $this->hasMany(Attendee::class);
}
}