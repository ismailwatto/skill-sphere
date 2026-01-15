@extends('layouts.guest')

@section('title', 'Sign In')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 450px; width: 100%;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h1 class="h3 fw-bold text-primary mb-2">Skill Sphere</h1>
                <p class="text-muted">Welcome back! Please sign in.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                    <label for="email">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        Remember me
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold">Sign In</button>
                </div>

                <!-- Forgot Password Link (Optional) -->
                <!-- 
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none small">Forgot password?</a>
                </div>
                -->
            </form>
        </div>
        <div class="card-footer bg-light text-center py-3 rounded-bottom-4 border-0">
             <small class="text-muted">&copy; {{ date('Y') }} Skill Sphere</small>
        </div>
    </div>
</div>
@endsection
