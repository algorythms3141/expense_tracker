@extends('layouts.app')

@section('title', 'Budgets')
@section('page-title', 'Budgets')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-piggy-bank me-2"></i>Budget Tracking
            </h5>
            <div class="d-flex gap-2">
                <form method="GET" action="{{ route('budgets.index') }}" class="d-flex gap-2">
                    <select name="month" class="form-select" onchange="this.form.submit()">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" class="form-select" onchange="this.form.submit()">
                        @for($y = date('Y') - 1; $y <= date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
                <a href="{{ route('budgets.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add Budget
                </a>
            </div>
        </div>

        @if($budgets->count() > 0)
            <div class="row">
                @foreach($budgets as $budget)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1">
                                            <span style="font-size: 1.2rem">{{ $budget->category->icon }}</span>
                                            {{ $budget->category->name }}
                                        </h6>
                                        <small class="text-muted">
                                            Budget: ₹{{ number_format($budget->amount, 2) }}
                                        </small>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link" type="button" data-bs-toggle="dropdown">
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
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Spent: ₹{{ number_format($budget->spent, 2) }}</span>
                                        <span>Remaining: ₹{{ number_format($budget->remaining, 2) }}</span>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar {{ $budget->percentage_used > 100 ? 'bg-danger' : ($budget->percentage_used > 80 ? 'bg-warning' : 'bg-success') }}" 
                                             role="progressbar" 
                                             style="width: {{ min($budget->percentage_used, 100) }}%">
                                            {{ number_format($budget->percentage_used, 1) }}%
                                        </div>
                                    </div>
                                </div>

                                @if($budget->percentage_used > 100)
                                    <div class="alert alert-danger py-2 mb-0 mt-2">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <small>Budget exceeded by ₹{{ number_format($budget->spent - $budget->amount, 2) }}</small>
                                    </div>
                                @elseif($budget->percentage_used > 80)
                                    <div class="alert alert-warning py-2 mb-0 mt-2">
                                        <i class="bi bi-exclamation-circle me-2"></i>
                                        <small>Approaching budget limit</small>
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

// Made with Bob
