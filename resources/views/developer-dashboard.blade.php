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

            <!-- Coming Soon Modules -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 opacity-50">
                    <div class="card-body p-4">
                        <div class="icon-box bg-secondary-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-shield-lock text-secondary fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Authentication System</h5>
                        <p class="text-muted small mb-4">Coming soon...</p>
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="bi bi-lock me-2"></i>Coming Soon
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 opacity-50">
                    <div class="card-body p-4">
                        <div class="icon-box bg-secondary-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-database text-secondary fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Database Architecture</h5>
                        <p class="text-muted small mb-4">Coming soon...</p>
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="bi bi-lock me-2"></i>Coming Soon
                        </button>
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


@section('title', 'Developer Dashboard')

@section('content')
<div class="row g-4">
    <!-- Page Header -->
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Developer Dashboard</h2>
                <p class="text-muted mb-0">Technical documentation and implementation guides</p>
            </div>
            <div>
                <span class="badge bg-primary-soft text-primary px-3 py-2">
                    <i class="bi bi-code-slash me-2"></i>Development Mode
                </span>
            </div>
        </div>
    </div>

    <!-- Implementation Modules Grid -->
    <div class="col-12">
        <div class="row g-4">
            <!-- Chat Module Card -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-primary-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-chat-dots-fill text-primary fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Live Chat Module</h5>
                        <p class="text-muted small mb-4">Real-time messaging system using Laravel Reverb and WebSockets</p>
                        
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-success-soft text-success">Laravel Reverb</span>
                            <span class="badge bg-info-soft text-info">WebSockets</span>
                            <span class="badge bg-warning-soft text-warning">Broadcasting</span>
                        </div>

                        <a href="#chatImplementation" class="btn btn-primary w-100" data-bs-toggle="collapse">
                            <i class="bi bi-book me-2"></i>View Implementation
                        </a>
                    </div>
                </div>
            </div>

            <!-- Placeholder for future modules -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift opacity-50">
                    <div class="card-body p-4">
                        <div class="icon-box bg-secondary-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-shield-lock text-secondary fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Authentication System</h5>
                        <p class="text-muted small mb-4">Coming soon...</p>
                        
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="bi bi-lock me-2"></i>Coming Soon
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift opacity-50">
                    <div class="card-body p-4">
                        <div class="icon-box bg-secondary-soft mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-database text-secondary fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Database Architecture</h5>
                        <p class="text-muted small mb-4">Coming soon...</p>
                        
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="bi bi-lock me-2"></i>Coming Soon
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Implementation Details (Collapsible) -->
    <div class="col-12">
        <div class="collapse" id="chatImplementation">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold mb-0">
                            <i class="bi bi-chat-dots-fill text-primary me-2"></i>
                            How to Implement Live Chat Module
                        </h4>
                        <button class="btn btn-sm btn-light rounded-pill" data-bs-toggle="collapse" data-bs-target="#chatImplementation">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-primary border-0 mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Overview:</strong> This guide shows you how the real-time chat module was implemented in this application.
                    </div>

                    <!-- Implementation sections will be added here -->
                    <div class="row g-4">
                        <div class="col-12">
                            <h5 class="fw-bold mb-3">
                                <span class="badge bg-primary me-2">1</span>
                                Backend Setup
                            </h5>
                            <p class="text-muted">Configure Laravel Reverb and broadcasting...</p>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold mb-3">
                                <span class="badge bg-primary me-2">2</span>
                                Database Schema
                            </h5>
                            <p class="text-muted">Create conversations and messages tables...</p>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold mb-3">
                                <span class="badge bg-primary me-2">3</span>
                                Frontend Integration
                            </h5>
                            <p class="text-muted">Set up Echo and WebSocket listeners...</p>
                        </div>

                        <div class="col-12">
                            <h5 class="fw-bold mb-3">
                                <span class="badge bg-primary me-2">4</span>
                                Real-time Broadcasting
                            </h5>
                            <p class="text-muted">Configure events and channels...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15) !important;
}

.bg-secondary-soft {
    background-color: rgba(108, 117, 125, 0.08);
}
</style>
@endsection
