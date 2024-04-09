<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function index()
    {
        // if (Auth::check()) {
        //     return redirect()->route('admin.dashboard');
        // }

        return view('login');
    }
}
