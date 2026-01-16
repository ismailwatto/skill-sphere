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
}
