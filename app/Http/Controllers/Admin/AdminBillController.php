<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\BookService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminBillController extends Controller
{
    /**
     * Display a listing of bills with filtering and statistics
     */
    public function index(Request $request)
    {
        $query = Bill::with(['bookService.client', 'bookService.deceased', 'payment']);
        
        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Search by client name or booking ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('bookService.client', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('book_service_id', 'like', "%{$search}%");
        }
        
        $bills = $query->latest()->paginate(15);
        
        // Current month statistics
        $currentMonthStats = $this->getMonthlyStats(Carbon::now());
        
        // Last month statistics
        $lastMonthStats = $this->getMonthlyStats(Carbon::now()->subMonth());
        
        // Calculate sales comparison
        $salesComparison = $this->calculateSalesComparison($currentMonthStats, $lastMonthStats);
        
        return view('admin.bill.index', compact('bills', 'currentMonthStats', 'lastMonthStats', 'salesComparison'));
    }
    
    /**
     * Get monthly statistics
     */
    private function getMonthlyStats($date)
    {
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $stats = Bill::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw('
                COUNT(*) as total_bills,
                SUM(total_amount - balance_amount) as total_sales,
                SUM(paid_amount) as total_paid,
                SUM(balance_amount) as total_balance,
                SUM(CASE WHEN payment_status = "paid" THEN 1 ELSE 0 END) as paid_count,
                SUM(CASE WHEN payment_status = "partial" THEN 1 ELSE 0 END) as partial_count,
                SUM(CASE WHEN payment_status = "pending" THEN 1 ELSE 0 END) as pending_count
            ')->first();

        return [
            'month_name' => $date->format('F Y'),
            'total_sales' => $stats->total_sales ?? 0,
            'total_paid' => $stats->total_paid ?? 0,
            'total_balance' => $stats->total_balance ?? 0,
            'total_bills' => $stats->total_bills ?? 0,
            'paid_count' => $stats->paid_count ?? 0,
            'partial_count' => $stats->partial_count ?? 0,
            'pending_count' => $stats->pending_count ?? 0,
        ];
    }

    
    /**
     * Calculate sales comparison between two months
     */
    private function calculateSalesComparison($current, $previous)
    {
        // Sales comparison
        $salesDifference = $current['total_sales'] - $previous['total_sales'];
        $salesPercentage = $previous['total_sales'] > 0 
            ? round(($salesDifference / $previous['total_sales']) * 100, 2) 
            : 0;
        
        // Paid comparison
        $paidDifference = $current['total_paid'] - $previous['total_paid'];
        $paidPercentage = $previous['total_paid'] > 0 
            ? round(($paidDifference / $previous['total_paid']) * 100, 2) 
            : 0;
        
        // Bills count comparison
        $billsDifference = $current['total_bills'] - $previous['total_bills'];
        $billsPercentage = $previous['total_bills'] > 0 
            ? round(($billsDifference / $previous['total_bills']) * 100, 2) 
            : 0;
        
        return [
            'sales_difference' => $salesDifference,
            'sales_percentage' => $salesPercentage,
            'sales_trend' => $salesDifference > 0 ? 'up' : ($salesDifference < 0 ? 'down' : 'same'),
            
            'paid_difference' => $paidDifference,
            'paid_percentage' => $paidPercentage,
            'paid_trend' => $paidDifference > 0 ? 'up' : ($paidDifference < 0 ? 'down' : 'same'),
            
            'bills_difference' => $billsDifference,
            'bills_percentage' => $billsPercentage,
            'bills_trend' => $billsDifference > 0 ? 'up' : ($billsDifference < 0 ? 'down' : 'same'),
        ];
    }

    /**
     * Show the form for creating a new bill
     */
    public function create()
    {
        // Get bookings that don't have bills yet
        $bookings = BookService::with(['client', 'deceased', 'package'])
            ->whereDoesntHave('bill')
            ->where('status', 'Confirmed')
            ->get();
        
        return view('admin.bill.create', compact('bookings'));
    }

    /**
     * Store a newly created bill
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_service_id' => 'required|exists:book_services,id|unique:bills,book_service_id',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0|lte:total_amount',
        ]);
        
        $paidAmount = $validated['paid_amount'] ?? 0;
        $balanceAmount = $validated['total_amount'] - $paidAmount;
        
        // Determine payment status
        if ($paidAmount == 0) {
            $paymentStatus = 'pending';
        } elseif ($balanceAmount > 0) {
            $paymentStatus = 'partial';
        } else {
            $paymentStatus = 'Fully paid';
        }
        
        $bill = Bill::create([
            'book_service_id' => $validated['book_service_id'],
            'total_amount' => $validated['total_amount'],
            'paid_amount' => $paidAmount,
            'balance_amount' => $balanceAmount,
            'payment_status' => $paymentStatus,
        ]);
        
        return redirect()->route('admin.bill.show', $bill->id)
            ->with('success', 'Bill created successfully');
    }

    /**
     * Display the specified bill with payment history
     */
    public function show(string $id)
    {
        $bill = Bill::with([
            'bookService.client.profile',
            'bookService.deceased',
            'bookService.package',
            'bookService.booking_items',
            'payment.processed_by'
        ])->findOrFail($id);
        
        return view('admin.bill.show', compact('bill'));
    }

    /**
     * Show the form for editing the bill
     */
    public function edit(string $id)
    {
        $bill = Bill::with('bookService.client')->findOrFail($id);
        
        return view('admin.bill.edit', compact('bill'));
    }

    /**
     * Update the specified bill
     */
    public function update(Request $request, string $id)
    {
        $bill = Bill::findOrFail($id);
        
        $validated = $request->validate([
            'total_amount' => 'required|numeric|min:0',
        ]);
        
        // Recalculate balance
        $balanceAmount = $validated['total_amount'] - $bill->paid_amount;
        
        // Update payment status
        if ($bill->paid_amount == 0) {
            $paymentStatus = 'pending';
        } elseif ($balanceAmount > 0) {
            $paymentStatus = 'partial';
        } else {
            $paymentStatus = 'Fully paid';
        }
        
        $bill->update([
            'total_amount' => $validated['total_amount'],
            'balance_amount' => $balanceAmount,
            'payment_status' => $paymentStatus,
        ]);
        
        return redirect()->route('admin.bill.show', $bill->id)
            ->with('success', 'Bill updated successfully');
    }

    /**
     * Remove the specified bill (soft delete consideration)
     */
    public function destroy(string $id)
    {
        $bill = Bill::findOrFail($id);
        
        // Check if there are any payments
        if ($bill->payment()->count() > 0) {
            return redirect()->route('admin.bill')
                ->with('error', 'Cannot delete bill with existing payments');
        }
        
        $bill->delete();
        
        return redirect()->route('admin.bill')
            ->with('success', 'Bill deleted successfully');
    }
    
    /**
     * Show payment form for a specific bill
     */
    public function showPaymentForm(string $billId)
    {
        $bill = Bill::with([
            'bookService.client.profile',
            'bookService.deceased',
            'payment'
        ])->findOrFail($billId);
        
        // Get all staff members who can process payments
        $staff = User::whereIn('accountType', ['admin', 'staff'])->get();
        
        return view('admin.bill.payment', compact('bill', 'staff'));
    }
    
    /**
     * Process a payment for a bill
     */
    public function processPayment(Request $request, string $billId)
    {
        $bill = Bill::findOrFail($billId);
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $bill->balance_amount,
            'payment_date' => 'required|date|before_or_equal:today',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Create payment record
            Payment::create([
                'bill_id' => $bill->id,
                'client_id' => $bill->bookService->client_id,
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'processed_by' => auth()->id(),
            ]);
            
            // Calculate new amounts
            // payment.amount + bill.paid_amount
            $newPaidAmount = $bill->paid_amount + $validated['amount'];
            
            // payment.amount - bill.balance_amount (which is: total - new paid amount)
            $newBalanceAmount = $bill->balance_amount - $validated['amount'];
            
            // Determine payment status
            // if bill.balance_amount = 0 then bill.payment_status = 'Fully paid'
            if ($newBalanceAmount <= 0) {
                $paymentStatus = 'Fully paid';
                $newBalanceAmount = 0; // Ensure it's exactly 0, not negative
            } else {
                // The payment.amount - bill.balance_amount and then set the bill.payment_status to 'partial'
                $paymentStatus = 'partial';
            }
            
            $bill->update([
                'paid_amount' => $newPaidAmount,
                'balance_amount' => $newBalanceAmount,
                'payment_status' => $paymentStatus,
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.bill.show', $bill->id)
                ->with('success', 'Payment processed successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Payment processing failed: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Show payment history
     */
    public function paymentHistory(Request $request)
    {
        $query = Payment::with(['bill.bookService.client', 'bill.bookService.deceased', 'processed_by']);
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }
        
        // Search by client name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('bill.bookService.client', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        
        $payments = $query->latest('payment_date')->paginate(20);
        
        return view('admin.bill.payment-history', compact('payments'));
    }
}