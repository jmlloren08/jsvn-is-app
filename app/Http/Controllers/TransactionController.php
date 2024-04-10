<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $outlets = Outlet::all();
        $products = Product::all();
        $traNumbers = Transaction::distinct()->pluck('tra_number');
        return view('admin.transactions', [
            'outlets'       => $outlets,
            'products'      => $products,
            'traNumbers'    => $traNumbers
        ]);

    }
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'transaction_no'            => 'required|numeric',
                'tra_number'                => 'required|numeric',
                'transaction_date'          => 'required|date',
                'transactions'              => 'required|array',
                'transactions.*.outlet_id'  => 'required|numeric',
                'transactions.*.product_id' => 'required|numeric',
                'transactions.*.unit_price' => 'required|numeric',
                'transactions.*.quantity'   => 'required|numeric',
                'transactions.*.total'      => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), 422]);
            }

            $transaction_no     = $request->transaction_no;
            $tra_number         = $request->tra_number;
            $transaction_date   = $request->transaction_date;
            $transactions       = $request->transactions;

            foreach ($transactions as $transactionData) {
                $transaction = new Transaction;
                $transaction->transaction_no    =   $transaction_no;
                $transaction->tra_number        =   $tra_number;
                $transaction->transaction_date  =   $transaction_date;
                $transaction->outlet_id         =   $transactionData['outlet_id'];
                $transaction->product_id        =   $transactionData['product_id'];
                $transaction->unit_price        =   $transactionData['unit_price'];
                $transaction->quantity          =   $transactionData['quantity'];
                $transaction->total             =   $transactionData['total'];
                $transaction->save();
            }
            return response()->json(['success' => $transaction]);
        } catch (\Exception $e) {

            Log::error("Error adding transaction: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $transaction = Transaction::findOrFail($id);

            $transaction->quantity  = $request->quantity;
            $transaction->on_hand   = $request->on_hand;
            $transaction->sold      = $request->sold;
            $transaction->total     = $request->total;
            $transaction->update();

            return response()->json(['message' => 'Date updated successfully.']);
        } catch (\Exception $e) {
            Log::error("Error updating onhand: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function getTransactions(Request $request)
    {
        $outletId       = $request->input('outlet_id');
        $date           = $request->input('date');

        $draw           = $request->input('draw');
        $start          = $request->input('start');
        $length         = $request->input('length');
        $searchValue    = $request->input('search.value');
        $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
        $orderDirection = $request->input('order.0.dir');

        $query          = Transaction::query();

        $query->join('products', 'transactions.product_id', '=', 'products.id');

        if (!empty($outletId)) {
            $query->where('transactions.outlet_id', $outletId);
        }

        if (!empty($date)) {
            $query->where('transactions.transaction_date', $date);
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->whereAny([
                    'products.product_description',
                    'transactions.transaction_no',
                    'transactions.transaction_date',
                    'transactions.quantity',
                    'transactions.on_hand',
                    'transactions.sold',
                    'transactions.unit_price',
                    'transactions.total',
                    'transactions.discounted_price'
                ], 'like', "%$searchValue%");
            });
        }

        $totalRecords = $query->count();

        $query->select('transactions.*', 'products.product_description');

        $query->orderBy($orderColumn, $orderDirection);
        $filteredRecords = $query->count();
        $transactions = $query->skip($start)
            ->take($length)
            ->get();

        $response = [
            'draw'              => intval($draw),
            'recordsTotal'      => $totalRecords,
            'recordsFiltered'   => $filteredRecords,
            'data'              => $transactions
        ];

        return response()->json($response, 200);
    }
    public function getTransactionNumber(Request $request)
    {
        $outletId   = $request->input('outlet_id');
        // $date       = $request->input('transaction_date');

        $transaction_no = Transaction::where('outlet_id', $outletId)
            // ->whereDate('transaction_date', $date)
            ->distinct()
            ->pluck('transaction_no');

        return response()->json(['transaction_no' => $transaction_no]);
    }
    public function delete($id)
    {
        Transaction::where('id', $id)->delete();

        return response()->json(['message' => 'Transaction deleted successfully.'], 200);
    }
    public function addDiscount(Request $request)
    {
        try {

            $discounts = $request->discounts;
            // loop through each item in the discount array
            foreach ($discounts as $discountData) {
                $id = $discountData['id'];
                $discountedPrice = $discountData['discounted_price'];
                // by the transaction record by id
                $transaction = Transaction::findOrFail($id);
                // update discounted price of each and every transaction id found
                $transaction->discounted_price = $discountedPrice;
                $transaction->update();
            }

            return response()->json(['message' => 'Data added successfully.']);
        } catch (\Exception $e) {
            Log::error("Error adding discount: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
