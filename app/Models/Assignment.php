<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'event_id',
        'freelancer_id',
        'status',
        // other fields...
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }
}
