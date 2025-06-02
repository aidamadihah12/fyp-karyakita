<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestController extends Controller
{
    private $arr = [
        ["name" => "jon", "family" => "doe"],
        ["name" => "jhon", "family" => "doue"]
    ];

    public function index()
    {
        return response()->json($this->arr); // Return JSON response
    }

    public function store(Request $request)
    {
        // Logic for storing data
        return response()->json(["message" => "oops!!"], 400);
    }

    public function update(Request $request, $id)
    {
        return response()->json(["message" => "test"]);
    }
}
