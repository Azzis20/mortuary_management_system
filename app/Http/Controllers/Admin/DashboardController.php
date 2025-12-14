<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookService;
use App\Models\BodyRetrieval;
use App\Models\Bill;
use App\Models\Inventory;
use App\Models\User;
use Carbon\Carbon;


class DashboardController extends Controller
{

        public function index()
        {
        $statusesToExclude = ['completed', 'cancelled', 'declined','pending'];
        $activeCase = BookService::whereNotIn('status', $statusesToExclude)->count();

        $pending = BookService::where('status', 'pending')->count();

        $todayRetrieval = BodyRetrieval::whereDate('retrieval_schedule', Carbon::today())->count();

        //Clients who took advantage of the service
        // $totalClients = BookService::distinct('client_id')->count('client_id');
        $totalClients = User::where('accountType', 'client')
                    ->distinct('id')
                    ->count('id');
        // $currentClients = BookService::where('created_at', '>=', now()->subDays(90))
        //                      ->distinct('user_id')
        //                      ->count('user_id');


        //current motnh total sales
        $currentMonth = Carbon::now();
        $startOfMonth = $currentMonth->copy()->startOfMonth();
        $endOfMonth = $currentMonth->copy()->endOfMonth();

        $currentMonthTotalSales = Bill::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('payment_status', 'fully paid')
            ->sum('total_amount');

        // Last Month total sales
        $lastMonth = Carbon::now()->subMonthNoOverflow();
        $startOfLastMonth = $lastMonth->copy()->startOfMonth();
        $endOfLastMonth = $lastMonth->copy()->endOfMonth();

        $lastMonthTotalSales = Bill::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->where('payment_status', 'fully paid')
            ->sum('total_amount');

        
        // Comparison
        $salesPercentageChange = 0;
        $salesComparisonStatus = 'same';

        if ($lastMonthTotalSales > 0) {
            $salesPercentageChange = (($currentMonthTotalSales - $lastMonthTotalSales) / $lastMonthTotalSales) * 100;

            if ($salesPercentageChange > 0) $salesComparisonStatus = 'increase';
            elseif ($salesPercentageChange < 0) $salesComparisonStatus = 'decrease';

        } elseif ($currentMonthTotalSales > 0) {
            $salesPercentageChange = 100;
            $salesComparisonStatus = 'increase';
        }

        $salesPercentageChange = number_format($salesPercentageChange, 2);

                // Get all items below their minimum threshold, ordered by stock quantity
        $stocks = Inventory::whereColumn('stock_quantity', '<=', 'min_threshold')
                        ->orderBy('stock_quantity', 'asc')
                        ->limit(2)
                        ->get();

        // If less than 2 items are below threshold, adjust to show only what's needed
        $limit = $stocks->count();

                      
        return view('admin.dashboard', compact('activeCase','pending','todayRetrieval','currentMonthTotalSales','lastMonthTotalSales','salesPercentageChange','salesComparisonStatus','totalClients','stocks'));
    }
   
    
}
