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
    'photographer_id',
];

protected $casts = [
    'event_date' => 'date:Y-m-d', // this ensures JSON returns correct format
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

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function payment()
{
    return $this->hasOne(Payment::class, 'booking_id');
}


public function photographer()
{
    return $this->belongsTo(User::class, 'photographer_id');
}

public function assignments()
{
    return $this->hasMany(\App\Models\Booking::class, 'event_id')->whereNotNull('photographer_id');
}


}
