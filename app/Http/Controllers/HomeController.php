<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Check if user has admin role and return appropriate view
        if (Auth()->User()->hasRole('admin')) {
            return view('home');
        }
        
        // Return default dashboard for non-admin users
        return view('home');
    }
}
