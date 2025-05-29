<?php

namespace App\Http\Controllers\Admin;

use App\Models\Queue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveViewController extends Controller
{
    /**
     * Display the live queue view.
     */
    public function index()
    {
        // Get the queue data, ordered by position
        $queue = Queue::orderBy('position')->get();
        return view('admin.liveview.index', compact('queue'));
    }

    /**
     * Reset the queue by clearing all entries.
     */
    public function reset()
    {
        // Clear all entries from the queue table
        Queue::truncate();

        // Redirect back to the live view page with a success message
        return redirect()->route('admin.liveview.index')->with('success', 'Queue has been reset.');
    }
}
