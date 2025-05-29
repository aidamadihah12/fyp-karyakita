<?php

// app/Models/Queue.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = ['name', 'position'];
}
