@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Summary Cards -->
<div class="row mb-4 g-3">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="stat-card income">
            <h6>Total Income</h6>
            <h3>₹{{ number_format($totalIncome, 2) }}</h3>
            <small><i class="bi bi-arrow-up-circle"></i> All time</small>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="stat-card expense">
            <h6>Total Expenses</h6>
            <h3>₹{{ number_format($totalExpenses, 2) }}</h3>
            <small><i class="bi bi-arrow-down-circle"></i> All time</small>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="stat-card savings">
            <h6>Total Savings</h6>
            <h3>₹{{ number_format($totalSavings, 2) }}</h3>
            <small><i class="bi bi-piggy-bank"></i> Net balance</small>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="stat-card monthly">
            <h6>This Month</h6>
            <h3>₹{{ number_format($currentMonthExpenses, 2) }}</h3>
            <small><i class="bi bi-calendar-month"></i> {{ now()->format('F Y') }}</small>
        </div>
    </div>
</div>

<!-- Today's Expenses Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            <i class="bi bi-calendar-day text-primary"></i> Today's Expenses
                        </h5>
                        <p class="text-muted mb-0 small">{{ now()->format('l, F j, Y') }}</p>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 text-primary">₹{{ number_format($todayExpenses, 2) }}</h2>
                        <a href="{{ route('expenses.create') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="bi bi-plus-circle"></i> Add Expense
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mb-4 g-3">
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-pie-chart me-2"></i>Category-wise Expenses
                </h5>
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-graph-up me-2"></i>Monthly Expense Trend
                </h5>
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">
            <i class="bi bi-clock-history me-2"></i>Recent Transactions
        </h5>
        
        @if($recentTransactions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">Date</th>
                            <th>Category</th>
                            <th class="d-none d-sm-table-cell">Merchant/Source</th>
                            <th class="d-none d-lg-table-cell">Type</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                            <tr>
                                <td class="d-none d-md-table-cell">
                                    <small>{{ \Carbon\Carbon::parse($transaction['date'])->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: {{ $transaction['color'] }}; font-size: 0.75rem;">
                                        {{ $transaction['category'] }}
                                    </span>
                                    <div class="d-md-none">
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($transaction['date'])->format('M d') }}</small>
                                    </div>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <small>{{ $transaction['merchant'] }}</small>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    @if($transaction['type'] === 'Income')
                                        <span class="badge bg-success">Income</span>
                                    @else
                                        <span class="badge bg-danger">Expense</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold">
                                    @if($transaction['type'] === 'Income')
                                        <span class="text-success">+₹{{ number_format($transaction['amount'], 2) }}</span>
                                    @else
                                        <span class="text-danger">-₹{{ number_format($transaction['amount'], 2) }}</span>
                                    @endif
                                    <div class="d-sm-none">
                                        <small class="text-muted">{{ $transaction['merchant'] }}</small>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No transactions yet. Start by adding your first expense or income!</p>
                <div class="mt-3">
                    <a href="{{ route('expenses.create') }}" class="btn btn-primary me-2">
                        <i class="bi bi-plus-circle me-2"></i>Add Expense
                    </a>
                    <a href="{{ route('income.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>Add Income
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Category Pie Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($categoryExpenses);
    
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryData.map(item => item.name),
            datasets: [{
                data: categoryData.map(item => item.total),
                backgroundColor: categoryData.map(item => item.color),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ₹' + context.parsed.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // Monthly Trend Line Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    const trendData = @json($monthlyTrend);
    
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendData.map(item => item.month),
            datasets: [{
                label: 'Expenses',
                data: trendData.map(item => item.total),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Expenses: ₹' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush

