<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}