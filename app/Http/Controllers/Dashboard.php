<?php

namespace App\Http\Controllers;

class Dashboard extends Controller
{
    public function index(){
        //start method
        return view('dashboard');
    }
}
