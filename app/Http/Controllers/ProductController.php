<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products');
    }
    public function getProducts(Request $request)
    {
        $draw           = $request->input('draw');
        $start          = $request->input('start');
        $length         = $request->input('length');
        $searchValue    = $request->input('search.value');
        $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
        $orderDirection = $request->input('order.0.dir');
        $query          = Product::query();

        if (!empty($searchValue)) {
            $query->whereAny([
                'product_name',
                'product_description',
                'product_unit_price'
            ], 'like', "%$searchValue%")->get();
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

        return response()->json($response, 200);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_name'          => 'required|string',
                'product_description'   => 'nullable|string',
                'product_unit_price'    => 'required|numeric'
            ]);

            $product = new Product;
            $product->product_name          = $request->product_name;
            $product->product_description   = $request->product_description;
            $product->product_unit_price    = $request->product_unit_price;
            $product->save();

            return response()->json(['message' => 'Data added successfully.'], 200);
        } catch (\Exception $e) {

            Log::error("Error updating product: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function edit($id)
    {
        $data = Product::where('id', $id)->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found.'], 404);
        }

        return response()->json($data);
    }
    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'product_name'          => 'required|string',
                'product_description'   => 'nullable|string',
                'product_unit_price'    => 'required|numeric'
            ]);

            $product = Product::findOrFail($id);

            $product->product_name          = $request->product_name;
            $product->product_description   = $request->product_description;
            $product->product_unit_price    = $request->product_unit_price;
            $product->save();

            return response()->json(['message' =>  'Data updated successfully.']);
        } catch (\Exception $e) {

            Log::error("Error updating product: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function delete($id)
    {
        Product::where('id', $id)->delete();

        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }
    public function getUnitPriceAndDescription($id)
    {
        try {
            $products = Product::findOrFail($id);
            return response()->json([
                'product_description'   => $products->product_description,
                'product_unit_price'    => $products->product_unit_price
            ]);
        } catch (\Exception $e) {

            Log::error("Error getting unit price and  description: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
