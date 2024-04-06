<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WarehouseController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.warehouse', ['products' => $products]);
    }
    public function getStocks(Request $request)
    {
        $draw           = $request->input('draw');
        $start          = $request->input('start');
        $length         = $request->input('length');
        $searchValue    = $request->input('search.value');
        $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
        $orderDirection = $request->input('order.0.dir');
        $query          = Warehouse::query();

        $query->join('products', 'warehouses.product_id', '=', 'products.id');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->whereAny([
                    'products.product_description',
                    'warehouses.stocks',
                    'warehouses.sold'
                ], 'like', "%$searchValue%");
            });
        }

        $totalRecords = $query->count();

        $query->select('warehouses.*', 'products.product_description');

        $query->orderBy($orderColumn, $orderDirection);
        $filteredRecords = $query->count();
        $stocks = $query->skip($start)
            ->take($length)
            ->get();

        $response = [
            'draw'              => intval($draw),
            'recordsTotal'      => $totalRecords,
            'recordsFiltered'   => $filteredRecords,
            'data'              => $stocks
        ];

        return response()->json($response, 200);
    }
    public function store(Request $request)
    {
        try {

            $request->validate([
                'product_id'    => 'required|numeric',
                'stocks'        => 'required|numeric'
            ]);

            $warehouse = new Warehouse;
            $warehouse->product_id  = $request->product_id;
            $warehouse->stocks      = $request->stocks;
            $warehouse->save();

            return response()->json(['message' => 'Data added successfully.'], 200);
        } catch (\Exception $e) {

            Log::error("Error adding stocks into warehouse: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function edit($id)
    {
        $data = Warehouse::where('id', $id)->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found.'], 404);
        }

        return response()->json($data);
    }
    public function update(Request $request, $id)
    {
        try {

            $warehouse = Warehouse::findOrFail($id);

            $warehouse->product_id      = $request->product_id_for_slip;
            $warehouse->stocks          = $request->remaining_stock_for_slip;
            $warehouse->quantity_out    = $request->quantity_out;
            $warehouse->quantity_return = $request->quantity_return;
            $warehouse->sold            = $request->sold;
            $warehouse->update();

            return response()->json(['message' => 'Data successfully updated']);
        } catch (\Exception $e) {

            Log::error("Error updating product: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function clearStock($id)
    {
        Warehouse::where('id', $id)->update([
            'quantity_out'      => null,
            'quantity_return'   => null,
            'sold'              => null
        ]);

        return response()->json(['message' => 'Out, return and total delivered cleared successfully.'], 200);
    }
    public function storeNewStock(Request $request, $id)
    {
        try {

            $warehouse = Warehouse::findOrFail($id);

            $warehouse->product_id  = $request->product_id_for_new_stock;
            $warehouse->stocks      = $request->total_stock;
            $warehouse->update();

            return response()->json(['message' =>  'Data added successfully.']);
        } catch (\Exception $e) {

            Log::error("Error updating product: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function delete($id)
    {
        Warehouse::where('id', $id)->delete();

        return response()->json(['message' => 'Stock deleted successfully.'], 200);
    }
}
