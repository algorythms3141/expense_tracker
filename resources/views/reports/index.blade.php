@extends('layouts.app')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-bar-chart me-2"></i>Financial Reports
            </h5>
            <form method="GET" action="{{ route('reports.index') }}" class="d-flex gap-2">
                <select name="month" class="form-select" onchange="this.form.submit()">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="form-select" onchange="this.form.submit()">
                    @for($y = date('Y') - 2; $y <= date('Y'); $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card income">
                    <h6>Total Income</h6>
                    <h3>₹{{ number_format($monthlyIncome, 2) }}</h3>
                    <small>{{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card expense">
                    <h6>Total Expenses</h6>
                    <h3>₹{{ number_format($monthlyExpenses, 2) }}</h3>
                    <small>{{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card {{ $monthlyIncome - $monthlyExpenses >= 0 ? 'savings' : 'expense' }}">
                    <h6>Net Savings</h6>
                    <h3>₹{{ number_format($monthlyIncome - $monthlyExpenses, 2) }}</h3>
                    <small>{{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</small>
                </div>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="mb-4">
            <a href="{{ route('reports.export.monthly', ['month' => $month, 'year' => $year]) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i>Export Monthly Report (CSV)
            </a>
            <a href="{{ route('reports.export.category', ['month' => $month, 'year' => $year]) }}" class="btn btn-info">
                <i class="bi bi-file-earmark-bar-graph me-2"></i>Export Category Report (CSV)
            </a>
        </div>
    </div>
</div>

<!-- Category-wise Report -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">
            <i class="bi bi-pie-chart me-2"></i>Category-wise Expense Report
        </h5>

        @if($categoryReport->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th class="text-center">Transactions</th>
                            <th class="text-end">Total Amount</th>
                            <th class="text-end">Average</th>
                            <th class="text-end">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalAmount = $categoryReport->sum('total'); @endphp
                        @foreach($categoryReport as $category)
                            <tr>
                                <td>
                                    <span class="badge" style="background-color: {{ $category->color }}">
                                        {{ $category->icon }} {{ $category->name }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $category->count }}</td>
                                <td class="text-end fw-bold">₹{{ number_format($category->total, 2) }}</td>
                                <td class="text-end">₹{{ number_format($category->total / $category->count, 2) }}</td>
                                <td class="text-end">
                                    <span class="badge bg-primary">
                                        {{ $totalAmount > 0 ? number_format(($category->total / $totalAmount) * 100, 1) : 0 }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <th>Total</th>
                            <th class="text-center">{{ $categoryReport->sum('count') }}</th>
                            <th class="text-end">₹{{ number_format($totalAmount, 2) }}</th>
                            <th></th>
                            <th class="text-end">100%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No expense data available for {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</p>
            </div>
        @endif
    </div>
</div>
@endsection

// Made with Bob
