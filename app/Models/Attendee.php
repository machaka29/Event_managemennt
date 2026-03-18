<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'organization'
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
