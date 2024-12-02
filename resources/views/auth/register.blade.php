@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100" 
    style="background: url('https://via.placeholder.com/1500') no-repeat center center / cover;">
    <div style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border-radius: 15px; padding: 30px; width: 100%; max-width: 400px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark">{{ __('Register') }}</h4>
            <p class="text-muted">{{ __('Create your account to access our platform') }}</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name Input -->
            <div class="form-group mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input id="name" type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="form-group mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="form-group mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div class="form-group mb-3">
                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" 
                    class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark">
                    {{ __('Register') }}
                </button>
            </div>
        </form>

        <!-- Back to Login Button -->
        <div class="text-center mt-3">
            <a class="btn btn-outline-dark" href="{{ route('login') }}">
                {{ __('Back to Login') }}
            </a>
        </div>
    </div>
</div>
@endsection
