@extends('layouts.guest')

@section('title', 'Forgot Password - Expense Tracker')

@section('content')
<div class="auth-header">
    <i class="bi bi-key brand-icon"></i>
    <h1>Forgot Password?</h1>
    <p>Enter your email to reset your password</p>
</div>

<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    Password reset functionality will be available soon. Please contact support for assistance.
</div>

<form method="POST" action="#">
    @csrf
    
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" required autofocus>
    </div>

    <button type="submit" class="btn btn-primary w-100" disabled>
        <i class="bi bi-envelope me-2"></i>Send Reset Link
    </button>
</form>

<div class="auth-footer">
    <p>
        Remember your password? <a href="{{ route('login') }}">Sign in</a>
    </p>
</div>
@endsection

