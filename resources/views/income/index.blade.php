@extends('layouts.app')

@section('title', 'Income')
@section('page-title', 'Income')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-arrow-down-circle me-2"></i>Income List
            </h5>
            <a href="{{ route('income.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>Add Income
            </a>
        </div>

        @if($income->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Source</th>
                            <th>Notes</th>
                            <th class="text-end">Amount</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($income as $inc)
                            <tr>
                                <td>{{ $inc->date->format('M d, Y') }}</td>
                                <td>{{ $inc->source }}</td>
                                <td>{{ Str::limit($inc->notes ?? '-', 40) }}</td>
                                <td class="text-end fw-bold text-success">₹{{ number_format($inc->amount, 2) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('income.edit', $inc) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('income.destroy', $inc) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="text-end text-success">₹{{ number_format($income->sum('amount'), 2) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3">
                {{ $income->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No income records found. Start by adding your first income!</p>
                <a href="{{ route('income.create') }}" class="btn btn-success mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Add Income
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

// Made with Bob
