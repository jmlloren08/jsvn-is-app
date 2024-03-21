<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products');
    }
    public function getProducts(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $orderColumn = $request->input("columns.{$request->input('order.0.column')}.data");
        $orderDirection = $request->input('order.0.dir');
        $query = Product::query();

        if (!empty($searchValue)) {
            $query->where('product_name', 'like', "%$searchValue%")
                ->orWhere('product_description', 'like', "%$searchValue%")
                ->orWhere('product_unit_price', 'like', "%$searchValue%");
        }

        $totalRecords = $query->count();
        $query->orderBy($orderColumn, $orderDirection);
        $filteredRecords = $query->count();
        $products = $query->skip($start)
            ->take($length)
            ->get(['*']);

        $response = [
            'draw'              => intval($draw),
            'recordsTotal'      => $totalRecords,
            'recordsFiltered'   => $filteredRecords,
            'data'              => $products
        ];

        return response()->json($response);
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_name'          => 'required',
            'product_description'   => 'nullable|string',
            'product_unit_price'    => 'required|numeric'
        ]);

        $product = new Product;
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_unit_price = $request->product_unit_price;
        $product->save();

        return response()->json(['res' => 'Product created successfully.']);
    }
    public function edit($id = null)
    {
        $data = Product::where('product_id', $id)->first();
        return response()->json($data);
    }
}
