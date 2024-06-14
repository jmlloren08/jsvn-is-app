<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Outlet;
use App\Models\Product;
use Illuminate\Http\Request;

class GenerateReportController extends Controller
{
    public function index()
    {
        $outlets = Outlet::all();
        $traNumbers = Transaction::whereNotNull('tra_number')
            ->where('tra_number', '!=', 0)
            ->distinct()
            ->pluck('tra_number');
        return view('admin.report', [
            'outlets'       => $outlets,
            'traNumbers'    => $traNumbers
        ]);
    }
    public function getTraNo(Request $request)
    {
        $outletId   = $request->input('outlet_id');

        $tra_number = Transaction::where('outlet_id', $outletId)
            ->where('tra_number', '!=', 0)
            ->distinct()
            ->pluck('tra_number');

        return response()->json(['tra_number' => $tra_number]);
    }
    public function generateReport(Request $request)
    {
        $traNumbers = $request->input('tra_numbers', []);
        $reportData = [];

        foreach ($traNumbers as $traNumber) {
            $transactions = Transaction::where('tra_number', $traNumber)->get();
            $transaction_date = $transactions->first()->transaction_date;
            $products = $this->getProductsForTRA($transactions);

            $reportData[$traNumber] = [
                'transaction_date'  => $transaction_date,
                'products'          => $products
            ];
        }

        return response()->json(['reportData' => $reportData], 200);
    }
    private function getProductsForTRA($transactions)
    {
        $products = [];
        $productIds = $transactions->pluck('product_id')->unique();
        $productsMap = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($transactions as $transaction) {
            $product = $productsMap[$transaction->product_id];

            $productData = [
                'id' => $product->id,
                'product_description' => $product->product_description,
                'quantity' => $transaction->quantity,
                'on_hand' => $transaction->on_hand,
                'sold' => $transaction->sold,
                'unit_price' => $transaction->unit_price,
                'discounted_price' => $transaction->discounted_price
            ];
            $products[] = $productData;

            usort($products, function ($a, $b) {
                return $a['id'] - $b['id'];
            });
        }
        return $products;
    }
}
