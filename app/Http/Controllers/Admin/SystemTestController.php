<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemTestController extends Controller
{
    // Show the system testing page
    public function index()
    {
        return view('admin.system.testing');
    }

    // Run system tests
    public function runTests(Request $request)
    {
        $results = [];

        // Test 1: Database connection
        try {
            \DB::connection()->getPdo();
            $results[] = "Database connection: SUCCESS";
        } catch (\Exception $e) {
            $results[] = "Database connection: FAILED - " . $e->getMessage();
        }

        // Test 2: Check storage folder writable
        $storagePath = storage_path('app');
        if (is_writable($storagePath)) {
            $results[] = "Storage folder writable: YES";
        } else {
            $results[] = "Storage folder writable: NO";
        }

        // Add more tests as needed...

        // Join results as string for display
        $testResults = implode("\n", $results);

        return redirect()->back()->with('testResults', $testResults);
    }
}
