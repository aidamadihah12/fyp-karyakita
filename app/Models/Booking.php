<?php

// App\Models\Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'event_id',
        'venue_id',
        'freelancer_id',
        'date',
        'status',
        'note',
        'package',
        'total_amount',
        'user_id', // optional
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }


    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
