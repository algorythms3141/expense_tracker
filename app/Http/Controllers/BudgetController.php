<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $budgets = Budget::forUser(Auth::id())
            ->forMonth($month, $year)
            ->with('category')
            ->get();

        // Add computed attributes
        $budgets->each(function ($budget) {
            $budget->spent = $budget->spent;
            $budget->remaining = $budget->remaining;
            $budget->percentage_used = $budget->percentage_used;
        });

        $categories = Category::where('user_id', Auth::id())->get();

        return view('budgets.index', compact('budgets', 'categories', 'month', 'year'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:2020'],
        ]);

        $validated['user_id'] = Auth::id();

        // Check if budget already exists for this category and month
        $exists = Budget::where('user_id', Auth::id())
            ->where('category_id', $validated['category_id'])
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'category_id' => 'Budget already exists for this category and month.'
            ])->withInput();
        }

        Budget::create($validated);

        return redirect()->route('budgets.index', [
            'month' => $validated['month'],
            'year' => $validated['year']
        ])->with('success', 'Budget created successfully!');
    }

    public function edit(Budget $budget)
    {
        // Ensure user owns this budget
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::where('user_id', Auth::id())->get();
        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        // Ensure user owns this budget
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:2020'],
        ]);

        // Check if budget already exists for this category and month (excluding current)
        $exists = Budget::where('user_id', Auth::id())
            ->where('category_id', $validated['category_id'])
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->where('id', '!=', $budget->id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'category_id' => 'Budget already exists for this category and month.'
            ])->withInput();
        }

        $budget->update($validated);

        return redirect()->route('budgets.index', [
            'month' => $validated['month'],
            'year' => $validated['year']
        ])->with('success', 'Budget updated successfully!');
    }

    public function destroy(Budget $budget)
    {
        // Ensure user owns this budget
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $month = $budget->month;
        $year = $budget->year;

        $budget->delete();

        return redirect()->route('budgets.index', [
            'month' => $month,
            'year' => $year
        ])->with('success', 'Budget deleted successfully!');
    }
}

