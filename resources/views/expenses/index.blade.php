@extends('layouts.app')

@section('title', 'Expenses')
@section('page-title', 'Expenses')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-cash-coin me-2"></i>Expenses</h4>
        <p class="text-muted mb-0 small">Manage your expense records</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
            <i class="bi bi-funnel me-1"></i> Filter
        </button>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> <span class="d-none d-sm-inline">Add </span>Expense
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <!-- Search and Filter -->
        <div class="mb-4">

            <!-- Collapsible Filter Form -->
            <div class="collapse d-md-block" id="filterCollapse">
                <form method="GET" action="{{ route('expenses.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3 col-12">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 col-12">
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
                        <div class="col-md-2 col-6">
                            <input type="date" name="start_date" class="form-control"
                                   placeholder="Start Date" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-2 col-6">
                            <input type="date" name="end_date" class="form-control"
                                   placeholder="End Date" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 col-12">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-2"></i>Apply Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if($expenses->count() > 0)
            <!-- Mobile Total Card - Show at top on mobile -->
            <div class="d-md-none mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Total Expenses:</h6>
                            <h4 class="mb-0 fw-bold">₹{{ number_format($expenses->sum('amount'), 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-md-block">
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
                                <td>{{ Str::limit($expense->notes ?? '-', 40) }}</td>
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

            <!-- Mobile Card View -->
            <div class="d-md-none">
                @foreach($expenses as $expense)
                    <div class="card mb-3 shadow-sm border-start border-4" style="border-left-color: {{ $expense->category->color }} !important; background: linear-gradient(to right, {{ $expense->category->color }}15, white);">
                        <div class="card-body pb-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge" style="background-color: {{ $expense->category->color }}">
                                        {{ $expense->category->icon }} {{ $expense->category->name }}
                                    </span>
                                </div>
                                <h5 class="mb-0 text-danger fw-bold">₹{{ number_format($expense->amount, 2) }}</h5>
                            </div>
                            
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-calendar3"></i> {{ $expense->date->format('M d, Y') }}
                                </small>
                            </div>
                            
                            @if($expense->merchant)
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-shop"></i> {{ $expense->merchant }}
                                    </small>
                                </div>
                            @endif
                            
                            @if($expense->notes)
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-sticky"></i> {{ Str::limit($expense->notes, 60) }}
                                    </small>
                                </div>
                            @endif
                            
                            <div class="d-flex gap-2 mt-2">
                                <div class="flex-fill">
                                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-primary w-100">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                </div>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                            onclick="return confirm('Are you sure you want to delete this expense?')">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $expenses->links('vendor.pagination.bootstrap-5') }}
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

