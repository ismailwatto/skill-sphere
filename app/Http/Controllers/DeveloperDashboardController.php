<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DeveloperDashboardController extends Controller
{
    /**
     * Display the developer dashboard.
     */
    public function __invoke(): View
    {
        return view('developer-dashboard');
    }

    /**
     * Display the chat module implementation guide.
     */
    public function chatModule(): View
    {
        return view('docs.chat-module');
    }

    /**
     * Display the authentication module implementation guide.
     */
    public function authModule(): View
    {
        return view('docs.auth-module');
    }

    /**
     * Display the email module implementation guide.
     */
    public function emailModule(): View
    {
        return view('docs.email-module');
    }

    /**
     * Display the CRUD module implementation guide.
     */
    public function crudModule(): View
    {
        return view('docs.crud-module');
    }

    public function paymentModule(): View
    {
        return view('docs.payment-module');
    }

    /**
     * Display the artisan commands implementation guide.
     */
    public function artisanCommandsModule(): View
    {
        return view('docs.artisan-commands');
    }
}