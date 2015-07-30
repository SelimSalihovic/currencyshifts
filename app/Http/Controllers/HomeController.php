<?php

namespace App\Http\Controllers;

use App\Repositories\ExampleResponseProvider;

class HomeController extends Controller
{
    public function index(ExampleResponseProvider $provider)
    {
        return view('home', compact('provider'));
    }
}
