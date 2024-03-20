<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name'          => 'required',
            'product_description'   => 'nullable|string',
            'product_unit_price'    => 'required|numberic'
        ]);

        Product::create([
            'product_name'          => $request->input('product_name'),
            'product_description'   => $request->input('product_description'),
            'product_unit_price'    => $request->input('product_unit_price')
        ]);

        return redirect()->route('admin.products.store')->with('success', 'Product created successfully.');
    }
}
