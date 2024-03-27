<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OutletController extends Controller
{
    public function index()
    {
        return view('admin.outlets');
    }
    public function getOutlets(Request $request)
    {
        $draw           = $request->input('draw');
        $start          = $request->input('start');
        $length         = $request->input('length');
        $searchValue    = $request->input('search.value');
        $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
        $orderDirection = $request->input('order.0.dir');
        $query          = Outlet::query();

        if (!empty($searchValue)) {
            $query->whereAny([
                'outlet_name',
                'outlet_cities_municipalities',
                'outlet_provinces'
            ], 'like', "%$searchValue%")->get();
        }

        $totalRecords = $query->count();
        $query->orderBy($orderColumn, $orderDirection);
        $filteredRecords = $query->count();
        $outlets = $query->skip($start)
            ->take($length)
            ->get(['*']);

        $response = [
            'draw'              => intval($draw),
            'recordsTotal'      => $totalRecords,
            'recordsFiltered'   => $filteredRecords,
            'data'              => $outlets
        ];

        return response()->json($response, 200);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'outlet_name'                   => 'required|string',
                'outlet_cities_municipalities'  => 'required|string',
                'outlet_provinces'              => 'required|string'
            ]);

            $outlet = new Outlet;
            $outlet->outlet_name                    = $request->outlet_name;
            $outlet->outlet_cities_municipalities   = $request->outlet_cities_municipalities;
            $outlet->outlet_provinces               = $request->outlet_provinces;
            $outlet->save();

            return response()->json(['message' => 'Data added successfully.'], 200);
        } catch (\Exception $e) {

            Log::error("Error updating outlet: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function edit($id)
    {
        $data = Outlet::where('id', $id)->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found.'], 404);
        }

        return response()->json($data);
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'outlet_name'                   => 'required|string',
                'outlet_cities_municipalities'  => 'required|string',
                'outlet_provinces'              => 'required|string'
            ]);

            $outlet = Outlet::findOrFail($id);

            $outlet->outlet_name                    = $request->outlet_name;
            $outlet->outlet_cities_municipalities   = $request->outlet_cities_municipalities;
            $outlet->outlet_provinces               = $request->outlet_provinces;
            $outlet->save();

            return response()->json(['message' => 'Data updated successfully.']);
        } catch (\Exception $e) {

            Log::error("Error updating outlet: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function delete($id)
    {
        Outlet::where('id', $id)->delete();

        return response()->json(['message' => 'Outlet deleted successfully.', 200]);
    }
    public function getOutletNameAddress($id)
    {
        $outlets = Outlet::findOrFail($id);
        $full_address = $outlets->outlet_cities_municipalities . ', ' . $outlets->outlet_provinces;
        return response()->json([
            'outlet_name'   => $outlets->outlet_name,
            'full_address'  => $full_address
        ]);
    }
    public function getOutletName($id)
    {
        $outlets = Outlet::findOrFail($id);
        return response()->json(['outlet_name' => $outlets->outlet_name]);
    }
}
