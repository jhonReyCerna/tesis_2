@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100" 
    style="background: url('https://via.placeholder.com/1500') no-repeat center center / cover;">
    <div style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border-radius: 15px; padding: 30px; width: 100%; max-width: 400px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark">{{ __('Login') }}</h4>
            <p class="text-muted">{{ __('Access your account...') }}</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Input -->
            <div class="form-group mb-3">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    name="password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark">
                    {{ __('Login') }}
                </button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center mt-3">
                    <a class="text-decoration-none text-dark" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif
        </form>

        <!-- Register Button -->
        <div class="text-center mt-3">
            <a href="{{ route('register') }}" class="btn btn-outline-dark">
                {{ __('Create an Account') }}
            </a>
        </div>
    </div>
</div>
@endsection
