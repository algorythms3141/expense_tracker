<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        $income = Income::forUser(Auth::id())
            ->latest('date')
            ->paginate(15);

        return view('income.index', compact('income'));
    }

    public function create()
    {
        return view('income.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'source' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['user_id'] = Auth::id();

        Income::create($validated);

        return redirect()->route('income.index')
            ->with('success', 'Income added successfully!');
    }

    public function edit(Income $income)
    {
        // Ensure user owns this income
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        return view('income.edit', compact('income'));
    }

    public function update(Request $request, Income $income)
    {
        // Ensure user owns this income
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'source' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $income->update($validated);

        return redirect()->route('income.index')
            ->with('success', 'Income updated successfully!');
    }

    public function destroy(Income $income)
    {
        // Ensure user owns this income
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $income->delete();

        return redirect()->route('income.index')
            ->with('success', 'Income deleted successfully!');
    }
}

