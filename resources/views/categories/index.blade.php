@extends('layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">
                <i class="bi bi-tags me-2"></i>Category List
            </h5>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Category
            </a>
        </div>

        @if($categories->count() > 0)
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card h-100" style="border-left: 4px solid {{ $category->color }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title">
                                            <span style="font-size: 1.5rem">{{ $category->icon }}</span>
                                            {{ $category->name }}
                                        </h5>
                                        @if($category->is_default)
                                            <span class="badge bg-secondary">Default</span>
                                        @endif
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('categories.edit', $category) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST">
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
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-circle-fill me-1" style="color: {{ $category->color }}"></i>
                                        Color: {{ $category->color }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-3">No categories found.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Add Category
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

// Made with Bob
