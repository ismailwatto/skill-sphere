@extends('layouts.standalone')

@section('title', 'Authentication Module')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-lg-11 col-xl-10 mx-auto">
            <div class="mb-4">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Documentation
                </a>
            </div>

            <div class="mb-5">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box bg-primary-soft me-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-shield-lock-fill text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-1">Authentication Module - Complete Implementation</h1>
                        <p class="text-muted mb-0">Login & Register system with Laravel authentication</p>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-success-soft text-success px-3 py-2">Laravel 11</span>
                    <span class="badge bg-info-soft text-info px-3 py-2">Session Auth</span>
                    <span class="badge bg-warning-soft text-warning px-3 py-2">Bootstrap 5</span>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">📋 Table of Contents</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#step1">1. Login Controller</a></li>
                                <li class="mb-2"><a href="#step2">2. Login View</a></li>
                                <li class="mb-2"><a href="#step3">3. Login Request</a></li>
                                <li class="mb-2"><a href="#step4">4. Guest Layout</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#step5">5. Register Controller</a></li>
                                <li class="mb-2"><a href="#step6">6. Register View</a></li>
                                <li class="mb-2"><a href="#step7">7. Routes</a></li>
                                <li class="mb-2"><a href="#step8">8. Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 1 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step1">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 1</span>
                        Create Login Controller
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">1.1 Create Controller</h5>
                    <pre class="code-block"><code>php artisan make:controller Auth/AuthenticatedSessionController</code></pre>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>app/Http/Controllers/Auth/AuthenticatedSessionController.php</code></p>
<pre class="code-block"><code>&lt;?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request-&gt;authenticate();

        $request-&gt;session()-&gt;regenerate();

        return redirect()-&gt;intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')-&gt;logout();

        $request-&gt;session()-&gt;invalidate();

        $request-&gt;session()-&gt;regenerateToken();

        return redirect('/');
    }
}</code></pre>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step2">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 2</span>
                        Create Login View
                    </h3>
                    
                    <p class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Create folder: <code>resources/views/auth</code>
                    </p>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>resources/views/auth/login.blade.php</code></p>
<pre class="code-block"><code>@@extends('layouts.guest')

@@section('title', 'Sign In')

@@section('content')
&lt;div class="container d-flex flex-column justify-content-center align-items-center min-vh-100"&gt;
    &lt;div class="card shadow-lg border-0 rounded-4" style="max-width: 450px; width: 100%;"&gt;
        &lt;div class="card-body p-5"&gt;
            &lt;div class="text-center mb-4"&gt;
                &lt;h1 class="h3 fw-bold text-primary mb-2"&gt;Skill Sphere&lt;/h1&gt;
                &lt;p class="text-muted"&gt;Welcome back! Please sign in.&lt;/p&gt;
            &lt;/div&gt;

            &lt;form method="POST" action="@{{ route('login') }}"&gt;
                @@csrf

                &lt;!-- Email Address --&gt;
                &lt;div class="form-floating mb-3"&gt;
                    &lt;input type="email" class="form-control @@error('email') is-invalid @@enderror" 
                           id="email" name="email" placeholder="name@example.com" 
                           value="@{{ old('email') }}" required autofocus&gt;
                    &lt;label for="email"&gt;Email Address&lt;/label&gt;
                    @@error('email')
                        &lt;div class="invalid-feedback"&gt;
                            @{{ $message }}
                        &lt;/div&gt;
                    @@enderror
                &lt;/div&gt;

                &lt;!-- Password --&gt;
                &lt;div class="form-floating mb-3"&gt;
                    &lt;input type="password" class="form-control @@error('password') is-invalid @@enderror" 
                           id="password" name="password" placeholder="Password" required&gt;
                    &lt;label for="password"&gt;Password&lt;/label&gt;
                    @@error('password')
                        &lt;div class="invalid-feedback"&gt;
                            @{{ $message }}
                        &lt;/div&gt;
                    @@enderror
                &lt;/div&gt;

                &lt;!-- Remember Me --&gt;
                &lt;div class="form-check mb-3"&gt;
                    &lt;input class="form-check-input" type="checkbox" name="remember" id="remember_me"&gt;
                    &lt;label class="form-check-label" for="remember_me"&gt;
                        Remember me
                    &lt;/label&gt;
                &lt;/div&gt;

                &lt;!-- Submit Button --&gt;
                &lt;div class="d-grid gap-2"&gt;
                    &lt;button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold"&gt;Sign In&lt;/button&gt;
                &lt;/div&gt;
            &lt;/form&gt;
        &lt;/div&gt;
        &lt;div class="card-footer bg-light text-center py-3 rounded-bottom-4 border-0"&gt;
             &lt;small class="text-muted"&gt;&amp;copy; @{{ date('Y') }} Skill Sphere&lt;/small&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
@@endsection</code></pre>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step3">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 3</span>
                        Create Login Request
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">3.1 Create Request</h5>
                    <pre class="code-block"><code>php artisan make:request Auth/LoginRequest</code></pre>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>app/Http/Requests/Auth/LoginRequest.php</code></p>
<pre class="code-block"><code>&lt;?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' =&gt; ['required', 'string', 'email'],
            'password' =&gt; ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        $this-&gt;ensureIsNotRateLimited();

        if (! Auth::attempt($this-&gt;only('email', 'password'), $this-&gt;boolean('remember'))) {
            RateLimiter::hit($this-&gt;throttleKey());

            throw ValidationException::withMessages([
                'email' =&gt; trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this-&gt;throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this-&gt;throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this-&gt;throttleKey());

        throw ValidationException::withMessages([
            'email' =&gt; trans('auth.throttle', [
                'seconds' =&gt; $seconds,
                'minutes' =&gt; ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this-&gt;input('email')).'|'.$this-&gt;ip());
    }
}</code></pre>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 4</span>
                        Create Guest Layout
                    </h3>
                    
                    <p class="text-muted mb-2"><strong>File:</strong> <code>resources/views/layouts/guest.blade.php</code></p>
<pre class="code-block"><code>&lt;!DOCTYPE html&gt;
&lt;html lang="@{{ str_replace('_', '-', app()-&gt;getLocale()) }}"&gt;
&lt;head&gt;
    &lt;meta charset="utf-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1"&gt;
    &lt;meta name="csrf-token" content="@{{ csrf_token() }}"&gt;

    &lt;title&gt;@@yield('title') | @{{ config('app.name', 'Laravel') }}&lt;/title&gt;

    &lt;!-- Scripts --&gt;
    @@vite(['resources/sass/app.scss', 'resources/js/app.js'])
&lt;/head&gt;
&lt;body class="bg-light"&gt;
    @@yield('content')
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                </div>
            </div>

            <!-- STEP 5 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step5">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 5</span>
                        Create Register Controller
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">5.1 Create Controller</h5>
                    <pre class="code-block"><code>php artisan make:controller Auth/RegisteredUserController</code></pre>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>app/Http/Controllers/Auth/RegisteredUserController.php</code></p>
<pre class="code-block"><code>&lt;?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request-&gt;validate([
            'name' =&gt; ['required', 'string', 'max:255'],
            'email' =&gt; ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' =&gt; ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' =&gt; $request-&gt;name,
            'email' =&gt; $request-&gt;email,
            'password' =&gt; Hash::make($request-&gt;password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}</code></pre>
                </div>
            </div>

            <!-- STEP 6 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step6">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 6</span>
                        Create Register View
                    </h3>
                    
                    <p class="text-muted mb-2"><strong>File:</strong> <code>resources/views/auth/register.blade.php</code></p>
<pre class="code-block"><code>@@extends('layouts.guest')

@@section('title', 'Register')

@@section('content')
&lt;div class="container d-flex flex-column justify-content-center align-items-center min-vh-100"&gt;
    &lt;div class="card shadow-lg border-0 rounded-4" style="max-width: 450px; width: 100%;"&gt;
        &lt;div class="card-body p-5"&gt;
            &lt;div class="text-center mb-4"&gt;
                &lt;h1 class="h3 fw-bold text-primary mb-2"&gt;Create Account&lt;/h1&gt;
                &lt;p class="text-muted"&gt;Join Skill Sphere today!&lt;/p&gt;
            &lt;/div&gt;

            &lt;form method="POST" action="@{{ route('register') }}"&gt;
                @@csrf

                &lt;!-- Name --&gt;
                &lt;div class="form-floating mb-3"&gt;
                    &lt;input type="text" class="form-control @@error('name') is-invalid @@enderror" 
                           id="name" name="name" placeholder="John Doe" 
                           value="@{{ old('name') }}" required autofocus&gt;
                    &lt;label for="name"&gt;Full Name&lt;/label&gt;
                    @@error('name')
                        &lt;div class="invalid-feedback"&gt;
                            @{{ $message }}
                        &lt;/div&gt;
                    @@enderror
                &lt;/div&gt;

                &lt;!-- Email Address --&gt;
                &lt;div class="form-floating mb-3"&gt;
                    &lt;input type="email" class="form-control @@error('email') is-invalid @@enderror" 
                           id="email" name="email" placeholder="name@example.com" 
                           value="@{{ old('email') }}" required&gt;
                    &lt;label for="email"&gt;Email Address&lt;/label&gt;
                    @@error('email')
                        &lt;div class="invalid-feedback"&gt;
                            @{{ $message }}
                        &lt;/div&gt;
                    @@enderror
                &lt;/div&gt;

                &lt;!-- Password --&gt;
                &lt;div class="form-floating mb-3"&gt;
                    &lt;input type="password" class="form-control @@error('password') is-invalid @@enderror" 
                           id="password" name="password" placeholder="Password" required&gt;
                    &lt;label for="password"&gt;Password&lt;/label&gt;
                    @@error('password')
                        &lt;div class="invalid-feedback"&gt;
                            @{{ $message }}
                        &lt;/div&gt;
                    @@enderror
                &lt;/div&gt;

                &lt;!-- Confirm Password --&gt;
                &lt;div class="form-floating mb-3"&gt;
                    &lt;input type="password" class="form-control @@error('password_confirmation') is-invalid @@enderror" 
                           id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required&gt;
                    &lt;label for="password_confirmation"&gt;Confirm Password&lt;/label&gt;
                    @@error('password_confirmation')
                        &lt;div class="invalid-feedback"&gt;
                            @{{ $message }}
                        &lt;/div&gt;
                    @@enderror
                &lt;/div&gt;

                &lt;!-- Submit Button --&gt;
                &lt;div class="d-grid gap-2"&gt;
                    &lt;button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold"&gt;Create Account&lt;/button&gt;
                &lt;/div&gt;

                &lt;!-- Login Link --&gt;
                &lt;div class="text-center mt-3"&gt;
                    &lt;small class="text-muted"&gt;Already have an account? 
                        &lt;a href="@{{ route('login') }}" class="text-decoration-none"&gt;Sign In&lt;/a&gt;
                    &lt;/small&gt;
                &lt;/div&gt;
            &lt;/form&gt;
        &lt;/div&gt;
        &lt;div class="card-footer bg-light text-center py-3 rounded-bottom-4 border-0"&gt;
             &lt;small class="text-muted"&gt;&amp;copy; @{{ date('Y') }} Skill Sphere&lt;/small&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
@@endsection</code></pre>
                </div>
            </div>

            <!-- STEP 7 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step7">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 7</span>
                        Add Routes
                    </h3>
                    
                    <p class="text-muted mb-2"><strong>File:</strong> <code>routes/web.php</code></p>
<pre class="code-block"><code>&lt;?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')-&gt;group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                -&gt;name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                -&gt;name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Authenticated Routes
Route::middleware('auth')-&gt;group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                -&gt;name('logout');
});</code></pre>
                </div>
            </div>

            <!-- STEP 8 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step8">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 8</span>
                        Add Logout Button
                    </h3>
                    
                    <p class="text-muted mb-3">Add logout button to your sidebar or header:</p>
<pre class="code-block"><code>&lt;form method="POST" action="@{{ route('logout') }}"&gt;
    @@csrf
    &lt;button type="submit" class="btn btn-link text-decoration-none"&gt;
        &lt;i class="bi bi-box-arrow-right me-2"&gt;&lt;/i&gt;Logout
    &lt;/button&gt;
&lt;/form&gt;</code></pre>
                </div>
            </div>

            <!-- Summary -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-success-soft">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4 text-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Summary
                    </h3>
                    <p class="mb-3">You now have a complete authentication system with:</p>
                    <ul class="mb-0">
                        <li>✅ Registration page with name, email & password</li>
                        <li>✅ Login page with email & password</li>
                        <li>✅ Password confirmation validation</li>
                        <li>✅ Remember me functionality</li>
                        <li>✅ Rate limiting (5 login attempts)</li>
                        <li>✅ Session management</li>
                        <li>✅ Logout functionality</li>
                        <li>✅ Bootstrap 5 styled forms</li>
                        <li>✅ Auto-login after registration</li>
                    </ul>
                </div>
            </div>

            <div class="text-center mt-5 mb-5">
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-arrow-left me-2"></i>Back to Documentation Home
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.code-block {
    background: #1e1e1e;
    color: #d4d4d4;
    padding: 1.25rem;
    border-radius: 8px;
    overflow-x: auto;
    font-family: 'Fira Code', 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 0;
}

.code-block code {
    background: transparent;
    color: #d4d4d4;
    padding: 0;
}
</style>
@endsection
