<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'service_type',
        'contact',
        'email',
        'phone',
        'address'
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}