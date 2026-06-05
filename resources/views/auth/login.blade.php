@extends('layouts.guest')

@section('title', 'Login - Expense Tracker')

@section('content')
<div class="auth-header">
    <i class="bi bi-wallet2 brand-icon"></i>
    <h1>Welcome Back</h1>
    <p>Sign in to your account</p>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" required autofocus>
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

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
    </button>
</form>

<div class="auth-footer">
    <p class="mb-2">
        <a href="{{ route('password.request') }}">Forgot your password?</a>
    </p>
    <p>
        Don't have an account? <a href="{{ route('register') }}">Sign up</a>
    </p>
</div>
@endsection

