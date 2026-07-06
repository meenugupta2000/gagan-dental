@extends('layouts.admin')

@section('title', 'Sign In')

@section('content')
@php($devLogin = app()->environment('local'))
<div class="auth-wrap">
    <button type="button" class="ltc-icon-btn ltc-theme-toggle auth-theme-toggle" title="Toggle theme" aria-label="Toggle theme">
        <i class="bi bi-moon-stars"></i>
    </button>
    <div class="auth-card">
        <div class="text-center mb-4">
            <div class="auth-mark"><i class="bi bi-heart-pulse-fill"></i></div>
            <div class="auth-logo">{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}</div>
            <p class="text-muted mb-0 mt-1">Sign in to your admin account</p>
        </div>

        @if ($devLogin)
            <div class="alert alert-warning d-flex align-items-center py-2 mb-3">
                <i class="bi bi-tools me-2"></i>
                <span class="small">Developer mode — credentials pre-filled.</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center py-2 mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <div class="position-relative">
                    <i class="bi bi-envelope position-absolute text-muted" style="left:.9rem;top:50%;transform:translateY(-50%);"></i>
                    <input type="email" name="email" value="{{ old('email', $devLogin ? 'superadmin@gagandentalclinic.com' : '') }}" class="form-control ps-5" placeholder="you@gagandentalclinic.com" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="position-relative">
                    <i class="bi bi-lock position-absolute text-muted" style="left:.9rem;top:50%;transform:translateY(-50%);"></i>
                    <input type="password" name="password" value="{{ $devLogin ? 'Super@12345' : '' }}" class="form-control ps-5" placeholder="••••••••" required>
                </div>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ $devLogin ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Keep me signed in</label>
            </div>
            <button type="submit" class="btn btn-brand btn-lg w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
            </button>
        </form>
    </div>
</div>
@endsection
