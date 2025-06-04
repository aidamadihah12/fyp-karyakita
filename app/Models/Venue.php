<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'package_type',
        'event_type',
        'available_date',
        'price',
        'sample_photo',
        'location_url',
    ];
}
