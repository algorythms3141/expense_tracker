<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Calculate summary statistics
        $totalIncome = Income::forUser($user->id)->sum('amount');
        $totalExpenses = Expense::forUser($user->id)->sum('amount');
        $totalSavings = $totalIncome - $totalExpenses;

        // Current month expenses
        $currentMonthExpenses = Expense::forUser($user->id)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        // Today's expenses
        $todayExpenses = Expense::forUser($user->id)
            ->whereDate('date', now()->toDateString())
            ->sum('amount');

        // Category-wise expenses for pie chart
        $categoryExpenses = Expense::where('expenses.user_id', $user->id)
            ->select('categories.name', 'categories.color', DB::raw('SUM(expenses.amount) as total'))
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total')
            ->get();

        // Monthly expense trend for last 6 months
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M Y');
            $total = Expense::forUser($user->id)
                ->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            $monthlyTrend[] = [
                'month' => $month,
                'total' => $total
            ];
        }

        // Recent transactions (last 10)
        $recentTransactions = collect();
        
        $recentExpenses = Expense::forUser($user->id)
            ->with('category')
            ->latest('date')
            ->limit(5)
            ->get()
            ->map(function ($expense) {
                return [
                    'date' => $expense->date,
                    'category' => $expense->category->name,
                    'merchant' => $expense->merchant ?? '-',
                    'amount' => $expense->amount,
                    'type' => 'Expense',
                    'color' => $expense->category->color,
                ];
            });

        $recentIncome = Income::forUser($user->id)
            ->latest('date')
            ->limit(5)
            ->get()
            ->map(function ($income) {
                return [
                    'date' => $income->date,
                    'category' => 'Income',
                    'merchant' => $income->source,
                    'amount' => $income->amount,
                    'type' => 'Income',
                    'color' => '#28a745',
                ];
            });

        $recentTransactions = $recentExpenses->concat($recentIncome)
            ->sortByDesc('date')
            ->take(10);

        return view('dashboard.index', compact(
            'totalIncome',
            'totalExpenses',
            'totalSavings',
            'currentMonthExpenses',
            'todayExpenses',
            'categoryExpenses',
            'monthlyTrend',
            'recentTransactions'
        ));
    }
}

