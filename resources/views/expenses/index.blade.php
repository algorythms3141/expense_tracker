@extends('layouts.app')

@section('title', 'Expenses')
@section('page-title', 'Expenses')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-cash-coin me-2"></i>Expense List
            </h5>
            <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Expense
            </a>
        </div>

        <!-- Search and Filter -->
        <form method="GET" action="{{ route('expenses.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->icon }} {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="start_date" class="form-control" 
                           placeholder="Start Date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="end_date" class="form-control" 
                           placeholder="End Date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>

        @if($expenses->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Merchant</th>
                            <th>Notes</th>
                            <th class="text-end">Amount</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                            <tr>
                                <td>{{ $expense->date->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge" style="background-color: {{ $expense->category->color }}">
                                        {{ $expense->category->icon }} {{ $expense->category->name }}
                                    </span>
                                </td>
                                <td>{{ $expense->merchant ?? '-' }}</td>
                                <td>{{ Str::limit($expense->notes ?? '-', 30) }}</td>
                                <td class="text-end fw-bold">₹{{ number_format($expense->amount, 2) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to delete this expense?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th class="text-end">₹{{ number_format($expenses->sum('amount'), 2) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3">
                {{ $expenses->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No expenses found. Start by adding your first expense!</p>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Add Expense
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

// Made with Bob
