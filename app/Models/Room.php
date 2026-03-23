<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location_id',
        'full_address',
        'latitude',
        'longitude',
        'rent',
        'room_type',
        'wifi',
        'ac',
        'food',
        'images',
        'rating',
        'is_available'
    ];

    protected $casts = [
        'images' => 'array',
        'wifi'   => 'boolean',
        'ac'     => 'boolean',
        'food'   => 'boolean',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}