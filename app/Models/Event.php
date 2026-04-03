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
    'user_id',
    'assigned_to',  // Add this
    'client_approved',
    'client_approved_at',
];

public function assignedTo()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

    protected $casts = [
        'event_date' => 'date',
        'budget' => 'decimal:2',
        'client_approved' => 'boolean',
        'client_approved_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Calculate total spent
    public function getTotalSpentAttribute()
    {
        return $this->services->sum('cost');
    }

    // Calculate remaining budget
    public function getRemainingBudgetAttribute()
    {
        return $this->budget - $this->total_spent;
    }

    // Budget usage percentage
    public function getBudgetUsagePercentAttribute()
    {
        if ($this->budget <= 0) return 0;
        return min(100, ($this->total_spent / $this->budget) * 100);
    }

    // Is over budget?
    public function getIsOverBudgetAttribute()
    {
        return $this->total_spent > $this->budget;
    }
}