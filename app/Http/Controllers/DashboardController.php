<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Warehouse;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStocks = Warehouse::sum('stocks');
        $totalSold = Warehouse::sum('sold');
        $today = Carbon::now()->format('Y-m-d');
        $totalDailySales = Transaction::whereDate('transaction_date', $today)->sum('total');
        return view('admin.dashboard', [
            'totalProducts'     => $totalProducts,
            'totalStocks'       => $totalStocks,
            'totalSold'         => $totalSold,
            'totalDailySales'   => $totalDailySales
        ]);
    }
}
