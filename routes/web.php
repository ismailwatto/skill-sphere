<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    
    // User & Role Management
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    // User Management
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('businesses', \App\Http\Controllers\BusinessController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);

    Route::resource('bookings', \App\Http\Controllers\BookingController::class);
    Route::resource('plans', \App\Http\Controllers\PlanController::class);
    
    // Chat Routes
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/start/{user}', [\App\Http\Controllers\ChatController::class, 'startConversation'])->name('chat.start');
    Route::get('/chat/{user:name}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}/send', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    // Payment Routes
    Route::get('/users/{user}/payment', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
});

// Stripe Handler
Route::post('/stripe/webhook', [\App\Http\Controllers\WebhookController::class, 'handleWebhook'])->name('stripe.webhook');

// Public Developer Documentation Routes
Route::get('/developer-dashboard', \App\Http\Controllers\DeveloperDashboardController::class)->name('developer.dashboard');
Route::get('/docs/chat-module', [\App\Http\Controllers\DeveloperDashboardController::class, 'chatModule'])->name('docs.chat');
Route::get('/docs/auth-module', [\App\Http\Controllers\DeveloperDashboardController::class, 'authModule'])->name('docs.auth');
Route::get('/docs/email-module', [\App\Http\Controllers\DeveloperDashboardController::class, 'emailModule'])->name('docs.email');
Route::get('/docs/crud-module', [\App\Http\Controllers\DeveloperDashboardController::class, 'crudModule'])->name('docs.crud');
Route::get('/docs/payment-module', [\App\Http\Controllers\DeveloperDashboardController::class, 'paymentModule'])->name('docs.payment');
Route::get('/docs/artisan-commands', [\App\Http\Controllers\DeveloperDashboardController::class, 'artisanCommandsModule'])->name('docs.artisan');

Route::get('/update-user-status', function () {
    $exitCode = Artisan::call('user:update-status');
    $output = Artisan::output();
    return response()->json([
        'message' => 'Command executed successfully',
        'exit_code' => $exitCode,
        'output' => trim($output)
    ]);
});
