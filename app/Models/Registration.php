<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'attendee_id',
        'ticket_id',
        'status',
        'attended',
        'check_in_at',
        'check_out_at'
    ];

    protected $casts = [
        'check_in_at' => 'datetime',
        'check_out_at' => 'datetime',
        'attended' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function attendee()
    {
        return $this->belongsTo(Attendee::class);
    }
}
