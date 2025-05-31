<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Add the fillable property to define which fields can be mass-assigned
    protected $fillable = [
        'name', 'date', 'available_slots', 'price', 'image'
    ];

    // Cast 'date' to Carbon instance
    protected $dates = ['date'];  // This will automatically convert 'date' field to Carbon instance

    // Define the relationship between Event and Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class); // Event has many bookings
    }
}
