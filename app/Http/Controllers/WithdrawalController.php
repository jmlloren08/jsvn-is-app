<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.withdrawal', ['products' => $products]);
    }
}
