@extends('layouts.app')

@section('title', 'Edit Income')
@section('page-title', 'Edit Income')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-pencil me-2"></i>Edit Income
                </h5>

                <form method="POST" action="{{ route('income.update', $income) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount *</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" step="0.01" name="amount" id="amount" 
                                   class="form-control @error('amount') is-invalid @enderror" 
                                   value="{{ old('amount', $income->amount) }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="source" class="form-label">Source *</label>
                        <input type="text" name="source" id="source" 
                               class="form-control @error('source') is-invalid @enderror" 
                               value="{{ old('source', $income->source) }}" placeholder="e.g., Salary, Freelance" required>
                        @error('source')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date *</label>
                        <input type="date" name="date" id="date" 
                               class="form-control @error('date') is-invalid @enderror" 
                               value="{{ old('date', $income->date->format('Y-m-d')) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="form-control @error('notes') is-invalid @enderror" 
                                  placeholder="Add any additional notes...">{{ old('notes', $income->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Update Income
                        </button>
                        <a href="{{ route('income.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

// Made with Bob
