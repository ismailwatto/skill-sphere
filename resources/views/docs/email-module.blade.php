@extends('layouts.standalone')

@section('title', 'Email with Queue Module')

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
                    <div class="icon-box bg-warning-soft me-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-envelope-fill text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-1">Email with Queue - Complete Implementation</h1>
                        <p class="text-muted mb-0">Send emails asynchronously using Laravel Mail and Queue</p>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-success-soft text-success px-3 py-2">Laravel 11</span>
                    <span class="badge bg-info-soft text-info px-3 py-2">Queue</span>
                    <span class="badge bg-warning-soft text-warning px-3 py-2">Async</span>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">📋 Table of Contents</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#step1">1. Configure Mail</a></li>
                                <li class="mb-2"><a href="#step2">2. Create Mailable</a></li>
                                <li class="mb-2"><a href="#step3">3. Create Email View</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#step4">4. Configure Queue</a></li>
                                <li class="mb-2"><a href="#step5">5. Send Email</a></li>
                                <li class="mb-2"><a href="#step6">6. Run Queue Worker</a></li>
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
                        Configure Mail Settings
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">1.1 Update .env File</h5>
                    <p class="text-muted mb-2">Configure your mail driver (example using Gmail):</p>
<pre class="code-block"><code>MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"</code></pre>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Note:</strong> For Gmail, use an App Password instead of your regular password. 
                        Enable 2FA and generate an app password from your Google Account settings.
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step2">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 2</span>
                        Create Mailable Class
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">2.1 Generate Mailable</h5>
                    <pre class="code-block"><code>php artisan make:mail WelcomeEmail</code></pre>

                    <p class="text-muted mb-2 mt-4"><strong>File:</strong> <code>app/Mail/WelcomeEmail.php</code></p>
<pre class="code-block"><code>&lt;?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $userName,
        public string $userEmail
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to SkillSphere!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}</code></pre>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step3">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 3</span>
                        Create Email View
                    </h3>
                    
                    <p class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Create folder: <code>resources/views/emails</code>
                    </p>

                    <p class="text-muted mb-2"><strong>File:</strong> <code>resources/views/emails/welcome.blade.php</code></p>
<pre class="code-block"><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;meta charset="utf-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;Welcome to SkillSphere&lt;/title&gt;
    &lt;style&gt;
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div class="header"&gt;
        &lt;h1&gt;Welcome to SkillSphere!&lt;/h1&gt;
    &lt;/div&gt;
    &lt;div class="content"&gt;
        &lt;h2&gt;Hello, @{{ $userName }}!&lt;/h2&gt;
        &lt;p&gt;Thank you for joining SkillSphere. We're excited to have you on board!&lt;/p&gt;
        &lt;p&gt;Your account has been successfully created with the email: &lt;strong&gt;@{{ $userEmail }}&lt;/strong&gt;&lt;/p&gt;
        &lt;p&gt;Get started by exploring our platform and discovering all the features we have to offer.&lt;/p&gt;
        &lt;a href="@{{ config('app.url') }}" class="button"&gt;Get Started&lt;/a&gt;
        &lt;p style="margin-top: 30px; color: #666; font-size: 14px;"&gt;
            If you have any questions, feel free to contact our support team.
        &lt;/p&gt;
    &lt;/div&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 4</span>
                        Configure Queue
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">4.1 Update .env for Queue</h5>
<pre class="code-block"><code>QUEUE_CONNECTION=database</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">4.2 Create Jobs Table</h5>
                    <pre class="code-block"><code>php artisan queue:table</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">4.3 Run Migration</h5>
                    <pre class="code-block"><code>php artisan migrate</code></pre>
                </div>
            </div>

            <!-- STEP 5 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step5">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 5</span>
                        Send Email with Queue
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">5.1 Send Email in Controller</h5>
                    <p class="text-muted mb-2">Example: Send welcome email after user registration</p>
<pre class="code-block"><code>&lt;?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        // Validate and create user
        $user = User::create([
            'name' =&gt; $request-&gt;name,
            'email' =&gt; $request-&gt;email,
            'password' =&gt; bcrypt($request-&gt;password),
        ]);

        // Send welcome email using queue
        Mail::to($user-&gt;email)
            -&gt;queue(new WelcomeEmail($user-&gt;name, $user-&gt;email));

        return redirect()-&gt;route('dashboard');
    }
}</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">5.2 Send Email Immediately (Without Queue)</h5>
<pre class="code-block"><code>// Send email immediately
Mail::to($user-&gt;email)
    -&gt;send(new WelcomeEmail($user-&gt;name, $user-&gt;email));</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">5.3 Send Email with Delay</h5>
<pre class="code-block"><code>// Send email after 5 minutes
Mail::to($user-&gt;email)
    -&gt;later(now()-&gt;addMinutes(5), new WelcomeEmail($user-&gt;name, $user-&gt;email));</code></pre>
                </div>
            </div>

            <!-- STEP 6 -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" id="step6">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4">
                        <span class="badge bg-primary me-2">Step 6</span>
                        Run Queue Worker
                    </h3>
                    
                    <h5 class="fw-bold mt-4 mb-3">6.1 Start Queue Worker</h5>
                    <pre class="code-block"><code>php artisan queue:work</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">6.2 Process Specific Queue</h5>
                    <pre class="code-block"><code>php artisan queue:work --queue=emails</code></pre>

                    <h5 class="fw-bold mt-4 mb-3">6.3 Run Queue Once</h5>
                    <pre class="code-block"><code>php artisan queue:work --once</code></pre>

                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Production Tip:</strong> Use a process manager like Supervisor to keep the queue worker running continuously in production.
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-success-soft">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4 text-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Summary
                    </h3>
                    <p class="mb-3">You now have a complete email system with queue:</p>
                    <ul class="mb-0">
                        <li>✅ Mail configuration (SMTP/Gmail)</li>
                        <li>✅ Mailable class for structured emails</li>
                        <li>✅ Beautiful HTML email templates</li>
                        <li>✅ Queue configuration (database driver)</li>
                        <li>✅ Asynchronous email sending</li>
                        <li>✅ Delayed email scheduling</li>
                        <li>✅ Queue worker management</li>
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

.bg-warning-soft {
    background-color: rgba(255, 193, 7, 0.08);
}
</style>
@endsection
