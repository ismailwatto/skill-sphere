@extends('layouts.standalone')

@section('title', 'Stripe Payment Module')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-lg-11 col-xl-10 mx-auto">
            <div class="mb-4">
                <a href="{{ route('developer.dashboard') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>

            <div class="mb-5">
                <h1 class="fw-bold mb-2">Stripe Payment Integration</h1>
                <p class="text-muted lead">
                    Complete guide to implementing subscription payments from scratch in Laravel.
                </p>
                <div class="alert alert-primary d-inline-block">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Goal:</strong> allow users to buy a "Plan" (like Basic/Pro) using Stripe.
                </div>
            </div>

            <!-- STEP 1: INSTALLATION -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">Step 1: Install the Stripe Package</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <p>Open your terminal in your project folder and run this command. This downloads the code we need to talk to Stripe.</p>
                    <pre class="code-block"><code>composer require stripe/stripe-php</code></pre>
                </div>
            </div>

            <!-- STEP 2: DATABASE -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">Step 2: Setup the Database</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <p>We need a table for <strong>Plans</strong> and some new columns in your <strong>Users</strong> table.</p>
                    
                    <h6 class="fw-bold mt-4">2.1 Create the Plans Migration</h6>
                    <p class="small text-muted">Run: <code>php artisan make:migration create_plans_table</code></p>
                    <p class="small text-muted">Then paste this into the new file in <code>database/migrations/</code>:</p>
                    <pre class="code-block"><code>public function up()
{
    Schema::create('plans', function (Blueprint $table) {
        $table->id();
        $table->string('name');         // e.g. "Gold Plan"
        $table->decimal('price', 8, 2); // e.g. 99.00
        $table->text('description')->nullable();
        $table->timestamps();
    });
}</code></pre>

                    <h6 class="fw-bold mt-4">2.2 Add Columns to Users Table</h6>
                    <p class="small text-muted">Run: <code>php artisan make:migration add_payment_columns_to_users_table</code></p>
                    <pre class="code-block"><code>public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // saves which plan the user selected
        $table->foreignId('plan_id')->nullable()->constrained('plans');
        // saves their Stripe Customer ID (starts with cus_...)
        $table->string('stripe_customer_id')->nullable();
        // saves their status: 'pending' or 'paid'
        $table->string('payment_status')->default('pending');
    });
}</code></pre>

                    <p class="mt-3">Finally, run the migrations to save changes:</p>
                    <pre class="code-block"><code>php artisan migrate</code></pre>
                </div>
            </div>

            <!-- STEP 3: MODELS -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">Step 3: Setup Models</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <p>Now we tell Laravel that a <strong>User</strong> belongs to a <strong>Plan</strong>.</p>
                    
                    <h6 class="fw-bold">Open <code>app/Models/User.php</code> and add:</h6>
                    <pre class="code-block"><code>// 1. Add these to the $fillable array so we can save them
protected $fillable = [
    'name', 
    'email', 
    'password', 
    'plan_id',             // <--- Add this
    'stripe_customer_id',  // <--- Add this
    'payment_status',      // <--- Add this
];

// 2. Add the relationship function
public function plan()
{
    return $this->belongsTo(Plan::class);
}</code></pre>
                </div>
            </div>

            <!-- STEP 4: ROUTES -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">Step 4: Create Routes</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <p>Open <code>routes/web.php</code> and add these lines. These are the URLs your app will use.</p>
                    <pre class="code-block"><code>use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;

// 1. The URL to start the payment (redirects to Stripe)
Route::get('/checkout/{user}', [PaymentController::class, 'checkout'])->name('payment.checkout');

// 2. The URL Stripe sends the user back to after success
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

// 3. The "Secret" URL Stripe talks to (Webhook)
Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);</code></pre>
                </div>
            </div>

            <!-- STEP 5: CONTROLLERS (The Meat) -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">Step 5: The Controllers (Copy & Paste)</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    
                    <h6 class="fw-bold text-dark">5.1 PaymentController.php</h6>
                    <p class="small text-muted">Create this file in <code>app/Http/Controllers/</code>.</p>
                    <pre class="code-block"><code>&lt;?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout(User $user)
    {
        // 1. Set your secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // 2. Create the checkout session
        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $user->plan->name, // Gets clear name from Plan model
                    ],
                    'unit_amount' => $user->plan->price * 100, // Stripe expects cents!
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('payment.success'),
            'cancel_url' => url('/'), // Where to go if they click cancel
            'metadata' => [
                'user_id' => $user->id, // Important: pass the user ID so we know who paid!
            ],
        ]);

        // 3. Redirect user to Stripe
        return redirect($checkout_session->url);
    }

    public function success()
    {
        return redirect('/')->with('success', 'Payment Successful!');
    }
}</code></pre>

                    <h6 class="fw-bold text-dark mt-5">5.2 WebhookController.php</h6>
                    <p class="small text-muted">Create this file in <code>app/Http/Controllers/</code>. This handles the actual update when payment completes.</p>
                    <pre class="code-block"><code>&lt;?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = @file_get_contents('php://input');
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            return response('Error', 400);
        }

        // Handle the event
        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;

            // Get the user ID we sent in metadata
            $userId = $session->metadata->user_id ?? null;
            
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    $user->update([
                        'payment_status' => 'paid',
                        'stripe_customer_id' => $session->customer
                    ]);
                }
            }
        }

        return response('Success', 200);
    }
}</code></pre>
                </div>
            </div>

            <!-- STEP 6: CRITICAL CONFIG -->
            <div class="card border-0 shadow-sm rounded-4 mb-5 border-start border-danger border-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-danger">⚠️ Crucial Step: Disable CSRF for Webhooks</h4>
                    <p>Laravel blocks external POST requests by default. We must tell it to allow Stripe's webhook.</p>
                    <p>Open <code>bootstrap/app.php</code> and find the middleware section. Add this exception:</p>
                    <pre class="code-block"><code>->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: [
        'stripe/*', // <--- Add this line!
    ]);
})</code></pre>
                </div>
            </div>

            <!-- STEP 7: USAGE -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">Step 7: The "Pay Now" Button</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <p>In your Blade view (e.g., <code>resources/views/customers.blade.php</code>), add this button:</p>
                    <pre class="code-block"><code>&lt;!-- Link to the checkout route, passing the user ID --&gt;
&lt;a href="@{{ route('payment.checkout', ['user' => $user->id]) }}" class="btn btn-success"&gt;
    Pay Now ($@{{ $user->plan->price }})
&lt;/a&gt;</code></pre>
                </div>
            </div>

            <!-- STEP 8: TESTING & DEPLOYMENT -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">Step 8: Testing & Going Live</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-local-tab" data-bs-toggle="pill" data-bs-target="#pills-local" type="button" role="tab">Localhost (Testing)</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-live-tab" data-bs-toggle="pill" data-bs-target="#pills-live" type="button" role="tab">Live Server (Production)</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Local Guide -->
                        <div class="tab-pane fade show active" id="pills-local" role="tabpanel">
                            <div class="alert alert-warning border-0 small">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Problem:</strong> Stripe can't send webhooks to <code>localhost</code> directly.
                                <br>
                                <strong>Solution:</strong> Use the Stripe CLI to forward events.
                            </div>
                            <ol>
                                <li class="mb-2">Download <a href="https://stripe.com/docs/stripe-cli" target="_blank" class="text-primary">Stripe CLI</a> (Windows zip).</li>
                                <li class="mb-2">Extract the <code>stripe.exe</code> file into a folder, e.g., <code>C:\Stripe</code>.</li>
                                <li class="mb-2">Open your terminal (CMD or PowerShell) and go to that folder:
                                    <pre class="bg-dark text-white p-2 rounded mt-1 mb-2"><code>cd C:\Stripe</code></pre>
                                </li>
                                <li class="mb-2">Login: <code>stripe login</code></li>
                                <li class="mb-2">
                                    Start forwarding:
                                    <div class="bg-dark text-white p-2 rounded mt-1 font-monospace small">
                                        stripe listen --forward-to localhost:8000/stripe/webhook
                                    </div>
                                </li>
                                <li class="mb-2"> It will show: <code>Your webhook signing secret is whsec_...</code></li>
                                <li class="mb-2"> Copy that secret and put it in your <code>.env</code>:
                                    <pre class="bg-dark text-white p-2 rounded mt-1"><code>STRIPE_WEBHOOK_SECRET=whsec_...</code></pre>
                                </li>
                            </ol>
                        </div>
                        
                        <!-- Live Guide -->
                        <div class="tab-pane fade" id="pills-live" role="tabpanel">
                            <div class="alert alert-success border-0 small">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Goal:</strong> Stripe sends webhooks directly to your live URL.
                            </div>
                            <ol>
                                <li class="mb-2">Deploy your code to your server (e.g., <code>https://skillsphere.com</code>).</li>
                                <li class="mb-2">Go to <a href="https://dashboard.stripe.com/webhooks" target="_blank" class="text-primary">Stripe Dashboard > Developers > Webhooks</a>.</li>
                                <li class="mb-2">Click <strong>"Add Endpoint"</strong>.</li>
                                <li class="mb-2">Endpoint URL: <code>https://your-domain.com/stripe/webhook</code></li>
                                <li class="mb-2">Select Events: <code>checkout.session.completed</code> (and others if needed).</li>
                                <li class="mb-2">After saving, click <strong>"Reveal"</strong> under "Signing secret".</li>
                                <li class="mb-2">Put that secret (starts with <code>whsec_</code>) in your production <code>.env</code> file.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FINAL CHECKLIST -->
            <div class="card bg-primary text-white border-0 shadow-sm rounded-4 mb-5">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-3">✅ Final Checklist</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bi bi-check-square-fill text-white me-2"></i> 
                            <span>Keys in <code>.env</code> (Key, Secret, Webhook Secret)</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bi bi-check-square-fill text-white me-2"></i> 
                            <span>Migrations run (<code>users</code> table has columns)</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bi bi-check-square-fill text-white me-2"></i> 
                            <span>CSRF disabled for <code>stripe/*</code> in bootstrap/app.php</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.code-block {
    background: #1e1e1e; /* Dark Bg */
    color: #e6e6e6; /* White text */
    padding: 1.5rem;
    border-radius: 8px;
    overflow-x: auto;
    font-family: 'Consolas', 'Monaco', monospace;
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    border: 1px solid #333;
}
.code-block code {
    color: #e6e6e6; 
}
</style>
@endsection
