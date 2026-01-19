@extends('layouts.standalone')

@section('title', 'Developer Documentation')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-primary text-white py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="mb-4">
                    <i class="bi bi-shield-check" style="font-size: 4rem;"></i>
                </div>
                <h1 class="display-4 fw-bold mb-3">SkillSphere Developer Documentation</h1>
                <p class="lead mb-4">
                    Welcome to SkillSphere - A comprehensive platform for managing skills, bookings, and real-time communication.
                    Built with Laravel, Bootstrap, and modern web technologies.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="#modules" class="btn btn-light btn-lg px-4">
                        <i class="bi bi-book me-2"></i>Explore Modules
                    </a>
                    <a href="#about" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-info-circle me-2"></i>About Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="py-5 bg-white" id="about">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="fw-bold mb-4">About SkillSphere</h2>
                <p class="lead text-muted mb-4">
                    SkillSphere is a modern business management platform designed to streamline operations, 
                    enhance customer engagement, and facilitate real-time communication between teams and clients.
                </p>
            </div>
        </div>
        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="icon-box bg-primary-soft mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 20px;">
                        <i class="bi bi-lightning-charge-fill text-primary" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="fw-bold">Fast & Reliable</h5>
                    <p class="text-muted">Built on Laravel framework for enterprise-grade performance</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="icon-box bg-success-soft mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 20px;">
                        <i class="bi bi-shield-check text-success" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="fw-bold">Secure</h5>
                    <p class="text-muted">Industry-standard security practices and authentication</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="icon-box bg-info-soft mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 20px;">
                        <i class="bi bi-puzzle-fill text-info" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="fw-bold">Modular</h5>
                    <p class="text-muted">Flexible architecture with reusable components</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modules Section -->
<div class="py-5 bg-light" id="modules">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Implementation Modules</h2>
            <p class="lead text-muted">Explore our technical documentation and implementation guides</p>
        </div>

        <div class="row g-4">
            <!-- Chat Module -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-primary-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-chat-dots-fill text-primary fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Live Chat Module</h5>
                        <p class="text-muted small mb-4">
                            Real-time messaging system using Laravel Reverb and WebSockets for instant communication.
                        </p>
                        
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-success-soft text-success">Laravel Reverb</span>
                            <span class="badge bg-info-soft text-info">WebSockets</span>
                            <span class="badge bg-warning-soft text-warning">Broadcasting</span>
                        </div>

                        <a href="{{ route('docs.chat') }}" class="btn btn-primary w-100">
                            <i class="bi bi-book me-2"></i>View Implementation
                        </a>
                    </div>
                </div>
            </div>

            <!-- Authentication Module -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-success-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-shield-lock-fill text-success fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Authentication System</h5>
                        <p class="text-muted small mb-4">
                            Login & session management with Laravel authentication and rate limiting.
                        </p>
                        
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-success-soft text-success">Session Auth</span>
                            <span class="badge bg-info-soft text-info">Rate Limiting</span>
                            <span class="badge bg-warning-soft text-warning">Bootstrap 5</span>
                        </div>

                        <a href="{{ route('docs.auth') }}" class="btn btn-success w-100">
                            <i class="bi bi-book me-2"></i>View Implementation
                        </a>
                    </div>
                </div>
            </div>
            <!-- Email with Queue Module -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-warning-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-envelope-fill text-warning fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Email with Queue</h5>
                        <p class="text-muted small mb-4">
                            Send emails asynchronously using Laravel Queue for better performance.
                        </p>
                        
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-success-soft text-success">Laravel Mail</span>
                            <span class="badge bg-info-soft text-info">Queue</span>
                            <span class="badge bg-warning-soft text-warning">Async</span>
                        </div>

                        <a href="{{ route('docs.email') }}" class="btn btn-warning w-100">
                            <i class="bi bi-book me-2"></i>View Implementation
                        </a>
                    </div>
                </div>
            </div>
            <!-- Crud Module -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-warning-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-grid-fill text-warning fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Crud in Laravel</h5>
                        <p class="text-muted small mb-4">
                            Crud in Laravel add edit update  and delete.
                        </p>
                        
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-success-soft text-success">Add</span>
                            <span class="badge bg-info-soft text-info">Edit</span>
                            <span class="badge bg-info-soft text-primary">Update</span>
                            <span class="badge bg-warning-soft text-warning">Delete</span>
                        </div>

                        <a href="{{ route('docs.crud') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-book me-2"></i>View Implementation
                        </a>
                    </div>
                </div>
            </div>
            <!-- Payment Module -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-primary-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-credit-card-2-front-fill text-primary fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Stripe Payments</h5>
                        <p class="text-muted small mb-4">
                            Subscription management and payment processing with Stripe integration.
                        </p>
                        
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-success-soft text-success">SDK</span>
                            <span class="badge bg-info-soft text-info">Webhooks</span>
                            <span class="badge bg-warning-soft text-warning">Plans</span>
                        </div>

                        <a href="{{ route('docs.payment') }}" class="btn btn-primary w-100">
                            <i class="bi bi-book me-2"></i>View Implementation
                        </a>
                    </div>
                </div>
            </div>
            <!-- Artisan Commands -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-dark-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-terminal-fill text-dark fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Artisan Commands</h5>
                        <p class="text-muted small mb-4">
                            Master the command line. Learn how to create, run, and schedule custom Artisan commands.
                        </p>
                        
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-dark-soft text-dark">Terminal</span>
                            <span class="badge bg-info-soft text-info">Scheduling</span>
                            <span class="badge bg-warning-soft text-warning">Automation</span>
                        </div>

                        <a href="{{ route('docs.artisan') }}" class="btn btn-outline-dark w-100">
                            <i class="bi bi-book me-2"></i>View Implementation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-shield-check me-2"></i>SkillSphere
                </h5>
                <p class="text-white-50 small">
                    Modern business management platform with real-time capabilities.
                </p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#about" class="text-white-50 text-decoration-none small">About</a></li>
                    <li class="mb-2"><a href="#modules" class="text-white-50 text-decoration-none small">Modules</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none small">API Documentation</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Contact</h6>
                <p class="text-white-50 small mb-2">
                    <i class="bi bi-envelope me-2"></i>info@skillsphere.com
                </p>
                <p class="text-white-50 small">
                    <i class="bi bi-github me-2"></i>github.com/skillsphere
                </p>
            </div>
        </div>
        <hr class="my-4 opacity-10">
        <div class="text-center text-white-50 small">
            © {{ date('Y') }} SkillSphere. All rights reserved.
        </div>
    </div>
</footer>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2) !important;
}

.bg-secondary-soft {
    background-color: rgba(108, 117, 125, 0.08);
}
</style>
@endsection

