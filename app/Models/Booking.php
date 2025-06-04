<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Event;
use App\Models\Venue;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'customer_id',  // foreign key pointing to users table
        'venue_id',
        'event_id',
        'freelancer_id',
        'date',
        'time',
        'package',
        'note',
        'status',
        'total_amount'
    ];

    // Relationships

    public function customer()
    {
        // customer_id references users table
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
