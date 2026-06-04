@extends('layouts.app')

@section('title', 'Add Category')
@section('page-title', 'Add Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-plus-circle me-2"></i>Add New Category
                </h5>

                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name *</label>
                        <input type="text" name="name" id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="e.g., Groceries" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon (Emoji)</label>
                        <input type="text" name="icon" id="icon" 
                               class="form-control @error('icon') is-invalid @enderror" 
                               value="{{ old('icon') }}" placeholder="e.g., 🛒" maxlength="10">
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Use an emoji or leave blank</small>
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color *</label>
                        <input type="color" name="color" id="color" 
                               class="form-control form-control-color @error('color') is-invalid @enderror" 
                               value="{{ old('color', '#667eea') }}" required>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Save Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
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
