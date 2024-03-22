<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

    public function Transaction()
    {
        return view('admin.transaction');
    }
    public function Warehouse()
    {
        return view('admin.warehouse');
    }
    public function Company()
    {
        return view('admin.company');
    }
    public function Outlet()
    {
        return view('admin.outlet');
    }
    public function Users()
    {
        return view('admin.users');
    }
}
