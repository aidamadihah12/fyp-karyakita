<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Add all expected fields including customer_id (foreign key)
    protected $fillable = [
        'name',
        'event_date',
        'available_slots',
        'price',
        'image',
        'location',
        'location_url',
        'package_type',
        'customer_id',
    ];

    // Use correct cast for event_date
    protected $casts = [
    'event_date' => 'date:Y-m-d', // Ensures proper formatting
    ];

    // Event belongs to a customer (user)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Event has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
