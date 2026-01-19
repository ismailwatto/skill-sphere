@extends('layouts.standalone')

@section('title', 'Artisan Commands Module')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-lg-11 col-xl-10 mx-auto">
            <div class="mb-4">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>

            <div class="mb-5">
                <h1 class="fw-bold mb-2">Artisan Commands & Automation</h1>
                <p class="text-muted lead">
                    Master the command line in Laravel. Learn how to create, run, and schedule custom commands.
                </p>
                <div class="alert alert-primary d-inline-block">
                    <i class="bi bi-terminal-fill me-2"></i>
                    <strong>What is Artisan?</strong> Artisan is the powerful command-line interface included with Laravel that helps you automate repetitive tasks.
                </div>
            </div>

            <!-- STEP 1: GENERATING A COMMAND -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">1. Creating a New Command</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <p>To create a new custom command, use the <code>make:command</code> Artisan command. This will create a new class in the <code>app/Console/Commands</code> directory.</p>
                    <pre class="code-block"><code>php artisan make:command SendWelcomeEmails</code></pre>
                    <p class="mt-3">After running this, you'll find a new file at <code>app/Console/Commands/SendWelcomeEmails.php</code>.</p>
                </div>
            </div>

            <!-- STEP 2: ANATOMY OF A COMMAND -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">2. The Command Anatomy</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <p>Every command has three main parts: <strong>Signature</strong>, <strong>Description</strong>, and <strong>Handle</strong>.</p>
                    
                    <h6 class="fw-bold mt-4">2.1 Signature & Description</h6>
                    <pre class="code-block"><code>protected $signature = 'user:welcome'; // Use this to run: php artisan user:welcome
protected $description = 'Sends a welcome email to all new users';</code></pre>

                    <h6 class="fw-bold mt-4">2.2 The Handle Method</h6>
                    <p>The <code>handle()</code> method is where your logic lives. This is what executes when you run the command.</p>
                    <pre class="code-block"><code>public function handle()
{
    // Write your code here
    $this->info('Sending welcome emails...');
    
    // Example logic
    // User::where('welcomed', false)->each(function($user) { ... });

    $this->info('Successfully sent welcome emails!');
}</code></pre>
                </div>
            </div>

            <!-- STEP 3: INPUT & OUTPUT -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-primary">3. Interacting with the Console</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <p>You can talk to the user and receive inputs easily.</p>
                    
                    <h6 class="fw-bold">Generating Output:</h6>
                    <pre class="code-block"><code>$this->info('Standard message (Green)');
$this->error('Error message (Red)');
$this->warn('Warning message (Yellow)');
$this->line('Plain text');</code></pre>

                    <h6 class="fw-bold mt-4">Receiving Input:</h6>
                    <pre class="code-block"><code>// Ask for a simple string
$name = $this->ask('What is your name?');

// Password entry (characters are hidden)
$password = $this->secret('Enter your secret password');

// Confirm an action
if ($this->confirm('Do you want to continue?')) {
    // ...
}</code></pre>
                </div>
            </div>

            <!-- STEP 4: TRIGGERING VIA CODE (WEB ROUTE) -->
            <div class="card border-0 shadow-sm rounded-4 mb-5 border-start border-warning border-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-warning"><i class="bi bi-lightning-fill me-2"></i>Triggering via Web Route</h4>
                    <p>Sometimes you need to run a command from a browser (URL) rather than the terminal. Use the <code>Artisan::call</code> method.</p>
                    <pre class="code-block"><code>use Illuminate\Support\Facades\Artisan;

Route::get('/run-welcome-emails', function () {
    $exitCode = Artisan::call('user:welcome');
    return "Command executed code: " . $exitCode;
});</code></pre>
                </div>
            </div>

            <!-- STEP 5: SCHEDULING COMMANDS -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold text-dark">Step 5: Scheduling Commands (Automation)</h4>
                </div>
                <div class="card-body px-4 pb-4">
                    <p>To run your command automatically (e.g., every day at midnight), register it in <code>routes/console.php</code>.</p>
                    <pre class="code-block"><code>use Illuminate\Support\Facades\Schedule;

Schedule::command('user:welcome')->daily();
// Other options: ->hourly(), ->everyMinute(), ->weekly()</code></pre>
                    
                    <div class="alert alert-dark border-0 small mt-3">
                        <i class="bi bi-clock-fill me-2"></i>
                        <strong>Crucial Tip:</strong> For this to work on a live server, you must add the "Master Cron Job" as shown in the Payment documentation!
                    </div>
                </div>
            </div>

            <!-- FINAL CHECKLIST -->
            <div class="card bg-primary text-white border-0 shadow-sm rounded-4 mb-5">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-3">✅ Command Checklist</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bi bi-check-square-fill text-white me-2"></i> 
                            <span>Check <code>app/Console/Commands</code> for your class files.</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bi bi-check-square-fill text-white me-2"></i> 
                            <span>Verify your <code>$signature</code> is unique.</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bi bi-check-square-fill text-white me-2"></i> 
                            <span>Run <code>php artisan list</code> to see your command in the list.</span>
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
