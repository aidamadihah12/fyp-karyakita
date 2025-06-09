<?php

// App\Models\Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
protected $fillable = [
    'event_id',
    'event_type',
    'event_date',
    'note',
    'total_amount',
    'status',
    'user_id',
    'location',
    'location_url',
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
