<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $user = Auth::user();

        // Monthly expense report
        $monthlyExpenses = Expense::forUser($user->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        $monthlyIncome = Income::forUser($user->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        // Category-wise report
        $categoryReport = Expense::where('expenses.user_id', $user->id)
            ->select('categories.name', 'categories.color', 'categories.icon', DB::raw('SUM(expenses.amount) as total'), DB::raw('COUNT(expenses.id) as count'))
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->whereMonth('expenses.date', $month)
            ->whereYear('expenses.date', $year)
            ->groupBy('categories.id', 'categories.name', 'categories.color', 'categories.icon')
            ->orderByDesc('total')
            ->get();

        return view('reports.index', compact('monthlyExpenses', 'monthlyIncome', 'categoryReport', 'month', 'year'));
    }

    public function exportMonthly(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $user = Auth::user();

        $expenses = Expense::forUser($user->id)
            ->with('category')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        $income = Income::forUser($user->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        $filename = "expense_report_{$year}_{$month}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($expenses, $income) {
            $file = fopen('php://output', 'w');

            // Expenses section
            fputcsv($file, ['EXPENSES']);
            fputcsv($file, ['Date', 'Category', 'Merchant', 'Amount', 'Notes']);

            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->date->format('Y-m-d'),
                    $expense->category->name,
                    $expense->merchant ?? '-',
                    number_format($expense->amount, 2),
                    $expense->notes ?? '-',
                ]);
            }

            fputcsv($file, ['']);
            fputcsv($file, ['Total Expenses', '', '', number_format($expenses->sum('amount'), 2)]);

            // Income section
            fputcsv($file, ['']);
            fputcsv($file, ['INCOME']);
            fputcsv($file, ['Date', 'Source', 'Amount', 'Notes']);

            foreach ($income as $inc) {
                fputcsv($file, [
                    $inc->date->format('Y-m-d'),
                    $inc->source,
                    number_format($inc->amount, 2),
                    $inc->notes ?? '-',
                ]);
            }

            fputcsv($file, ['']);
            fputcsv($file, ['Total Income', '', number_format($income->sum('amount'), 2)]);

            // Summary
            fputcsv($file, ['']);
            fputcsv($file, ['SUMMARY']);
            fputcsv($file, ['Total Income', number_format($income->sum('amount'), 2)]);
            fputcsv($file, ['Total Expenses', number_format($expenses->sum('amount'), 2)]);
            fputcsv($file, ['Net Savings', number_format($income->sum('amount') - $expenses->sum('amount'), 2)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCategory(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $user = Auth::user();

        $categoryReport = Expense::forUser($user->id)
            ->select('categories.name', DB::raw('SUM(expenses.amount) as total'), DB::raw('COUNT(expenses.id) as count'))
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->whereMonth('expenses.date', $month)
            ->whereYear('expenses.date', $year)
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->get();

        $filename = "category_report_{$year}_{$month}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($categoryReport) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['CATEGORY-WISE EXPENSE REPORT']);
            fputcsv($file, ['Category', 'Total Amount', 'Transaction Count', 'Average']);

            foreach ($categoryReport as $category) {
                $average = $category->count > 0 ? $category->total / $category->count : 0;
                fputcsv($file, [
                    $category->name,
                    number_format($category->total, 2),
                    $category->count,
                    number_format($average, 2),
                ]);
            }

            fputcsv($file, ['']);
            fputcsv($file, ['Total', number_format($categoryReport->sum('total'), 2), $categoryReport->sum('count')]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

// Made with Bob
