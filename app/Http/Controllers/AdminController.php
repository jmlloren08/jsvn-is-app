<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function Profile()
    {
        // $id = Auth::user()->id;
        // $adminData = User::find($id);
        return view('admin.admin_profile_view');
    }
    public function Users()
    {
        return view('admin.users');
    }
}
