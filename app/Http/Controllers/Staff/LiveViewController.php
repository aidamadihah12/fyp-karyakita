<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

class LiveViewController extends Controller
{
    public function index()
    {
        return view('staff.liveview.index');
    }
}
