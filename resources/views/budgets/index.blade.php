@extends('layouts.app')

@section('title', 'Budgets')
@section('page-title', 'Budgets')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="bi bi-piggy-bank me-2"></i>Budgets</h4>
        <p class="text-muted mb-0 small">Track your monthly budgets</p>
    </div>
    <a href="{{ route('budgets.create') }}" class="btn btn-primary d-none d-md-inline-flex">
        <i class="bi bi-plus-circle me-2"></i>Add Budget
    </a>
    <a href="{{ route('budgets.create') }}" class="btn btn-primary d-md-none">
        <i class="bi bi-plus-circle"></i>
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('budgets.index') }}" class="row g-3">
            <div class="col-md-5 col-6">
                <label class="form-label small">Month</label>
                <select name="month" class="form-select" onchange="this.form.submit()">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-5 col-6">
                <label class="form-label small">Year</label>
                <select name="year" class="form-select" onchange="this.form.submit()">
                    @for($y = date('Y') - 1; $y <= date('Y') + 1; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2 col-12 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-funnel me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Budget Cards -->
<div class="card">
    <div class="card-body">
        @if($budgets->count() > 0)
            <div class="row">
                @foreach($budgets as $budget)
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="card border-start border-4" style="border-left-color: {{ $budget->category->color }} !important;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 d-flex align-items-center">
                                            <span style="font-size: 1.2rem" class="me-2">{{ $budget->category->icon }}</span>
                                            <span>{{ $budget->category->name }}</span>
                                        </h6>
                                        <small class="text-muted d-block">
                                            Budget: <strong>₹{{ number_format($budget->amount, 2) }}</strong>
                                        </small>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-dark p-1" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('budgets.edit', $budget) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('budgets.destroy', $budget) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                        <i class="bi bi-trash me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="d-flex justify-content-between mb-2 small">
                                        <span class="text-muted">Spent: <strong class="text-dark">₹{{ number_format($budget->spent, 2) }}</strong></span>
                                        <span class="text-muted">Remaining: <strong class="text-dark">₹{{ number_format($budget->remaining, 2) }}</strong></span>
                                    </div>
                                    <div class="progress" style="height: 24px;">
                                        <div class="progress-bar {{ $budget->percentage_used > 100 ? 'bg-danger' : ($budget->percentage_used > 80 ? 'bg-warning' : 'bg-success') }}"
                                             role="progressbar"
                                             style="width: {{ min($budget->percentage_used, 100) }}%">
                                            <strong>{{ number_format($budget->percentage_used, 1) }}%</strong>
                                        </div>
                                    </div>
                                </div>

                                @if($budget->percentage_used > 100)
                                    <div class="alert alert-danger py-2 px-3 mb-0 mt-2 d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <small class="mb-0">Budget exceeded by ₹{{ number_format($budget->spent - $budget->amount, 2) }}</small>
                                    </div>
                                @elseif($budget->percentage_used > 80)
                                    <div class="alert alert-warning py-2 px-3 mb-0 mt-2 d-flex align-items-center">
                                        <i class="bi bi-exclamation-circle me-2"></i>
                                        <small class="mb-0">Approaching budget limit</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No budgets set for {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</p>
                <a href="{{ route('budgets.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Create Budget
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

