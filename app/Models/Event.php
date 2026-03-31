<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'date',
        'time',
        'location',
        'capacity',
        'image_path',
        'reg_start_date',
        'reg_end_date',
        'organizer_id',
        'status',
        'category_id',
        'venue',
        'target_audience',
        'gate_password'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($event) {
            if (empty($event->slug)) {
                $slug = \Illuminate\Support\Str::slug($event->title);
                $originalSlug = $slug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
                $event->slug = $slug;
            }
        });
    }
}
