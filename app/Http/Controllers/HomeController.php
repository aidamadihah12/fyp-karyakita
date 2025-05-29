<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Uncomment the next line when using FirebaseService
// use App\Services\FirebaseService;

class HomeController extends Controller
{
    // Uncomment this property when using FirebaseService
    // protected $firebase;

    // Uncomment this constructor to inject FirebaseService
    /*
    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }
    */

    public function index()
    {
        // Static images for development/demo:
        $portfolioImages = [
            asset('images/image1.jpg'),
            asset('images/image2.jpg'),
            asset('images/image3.jpg'),
        ];

        // Uncomment below to use Firebase dynamic images instead:
        // $portfolioImages = $this->firebase->listPortfolioImages();

        return view('home', compact('portfolioImages'));
    }
}
