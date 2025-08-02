<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $transactions = Transaction::where('user_id', $user->id)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $categories = Category::where('user_id', $user->id)
            ->latest()
            ->get();

        // Statistik bulanan untuk chart
        $monthlyStats = Transaction::selectRaw('
                MONTH(date) as month_number,
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense
            ')
            ->where('user_id', $user->id)
            ->whereYear('date', now()->year)
            ->groupBy(DB::raw('MONTH(date)'))
            ->orderBy('month_number')
            ->get();

        $monthLabels = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        foreach ($monthlyStats as $stat) {
            $stat->month = $monthLabels[$stat->month_number];
        }

        return view('dashboard', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'transactions' => $transactions,
            'categories' => $categories,
            'monthlyStats' => $monthlyStats
        ]);
    }
}
