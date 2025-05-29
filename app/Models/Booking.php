<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Define the table name (optional if the table name follows Laravel's convention)
    protected $table = 'bookings';

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id',        // The user who made the booking
        'event_id',       // The related event for this booking
        'event_type',     // Event Type (e.g. Wedding, Conference, etc.)
        'event_date',     // The date of the event
        'total_amount',   // Total amount for the event booking
        'status',         // Booking status (Pending, Confirmed, Completed)
        'freelancer_id',  // Freelancer assigned to the booking (optional)
    ];

    // Automatically cast event_date to Carbon (date object)
    protected $casts = [
        'event_date' => 'date',  // Ensure event_date is handled as a Carbon date object
    ];

    // Relationships

    // Define the relation with the User model (who made the booking)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Belongs to User model
    }

    // Define the relation with the Freelancer (who is assigned to the booking)
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id'); // Belongs to the freelancer (a user)
    }

    // Define the relation with the Event model (related event for this booking)
    public function event()
    {
        return $this->belongsTo(Event::class); // Belongs to Event model
    }

    // Optional: You can define additional methods if needed
}
