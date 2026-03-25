<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'client_id',
        'vendor_id',
        'phone',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Role identification methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isVendor(): bool
    {
        return $this->role === 'vendor';
    }

    // Get role display info
    public function getRoleBadgeAttribute(): string
    {
        $badges = [
            'admin' => '<span class="badge bg-danger">Administrator</span>',
            'manager' => '<span class="badge bg-primary">Event Manager</span>',
            'staff' => '<span class="badge bg-info">Staff</span>',
            'client' => '<span class="badge bg-success">Client</span>',
            'vendor' => '<span class="badge bg-warning text-dark">Vendor</span>',
        ];
        
        return $badges[$this->role] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getRoleIconAttribute(): string
    {
        $icons = [
            'admin' => 'bi-shield-lock',
            'manager' => 'bi-briefcase',
            'staff' => 'bi-person-badge',
            'client' => 'bi-person',
            'vendor' => 'bi-shop',
        ];
        
        return $icons[$this->role] ?? 'bi-person';
    }

    public function getDashboardRouteAttribute(): string
    {
        return match($this->role) {
            'client' => 'client.dashboard',
            'vendor' => 'vendor.dashboard',
            default => 'dashboard',
        };
    }

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Scope queries
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }
}