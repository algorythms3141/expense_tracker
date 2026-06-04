@extends('layouts.guest')

@section('title', 'Register - Expense Tracker')

@section('content')
<div class="auth-header">
    <i class="bi bi-wallet2 brand-icon"></i>
    <h1>Create Account</h1>
    <p>Start tracking your expenses today</p>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" 
               id="password_confirmation" name="password_confirmation" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-person-plus me-2"></i>Create Account
    </button>
</form>

<div class="auth-footer">
    <p>
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </p>
</div>
@endsection

// Made with Bob
