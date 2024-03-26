<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $outlets = Outlet::all();
        $products = Product::all();
        return view('admin.transactions', [
            'outlets'   => $outlets,
            'products'  => $products
        ]);
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'transaction_no'                    => 'required|numeric',
                'transaction_date'                  => 'required|date',
                'transactions'                      => 'required|array',
                'transactions.*.product_id'         => 'required|numeric',
                'transactions.*.unit_price'         => 'required|numeric',
                'transactions.*.quantity'           => 'required|numeric',
                'transactions.*.total'              => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), 422]);
            }

            $transaction_no     = $request->transaction_no;
            $transaction_date   = $request->transaction_date;
            $transactions       = $request->transactions;

            foreach ($transactions as $transactionData) {
                $transaction = new Transaction;
                $transaction->transaction_no    =   $transaction_no;
                $transaction->transaction_date  =   $transaction_date;
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
    public function getTransactions(Request $request)
    {
        $draw           = $request->input('draw');
        $start          = $request->input('start');
        $length         = $request->input('length');
        $searchValue    = $request->input('search.value');
        $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
        $orderDirection = $request->input('order.0.dir');
        $query          = Transaction::query();

        $query->join('products', 'transactions.product_id', '=', 'products.id');

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
                    'transactions.total'
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
}
