@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="mb-5">
            <h3 class="fw-bold mb-0">Profile Settings</h3>
            <p class="text-muted small">Update your personal information and account security.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="d-flex align-items-center gap-4 mb-5 pb-4 border-bottom">
                        <div class="position-relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=120&color=7F9CF5&background=EBF4FF" alt="avatar" class="rounded-circle shadow-sm border border-4 border-white">
                            <div class="position-absolute bottom-0 end-0 bg-primary text-white p-1 rounded-circle border border-2 border-white shadow-sm" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-camera-fill extra-small"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill extra-small fw-bold">
                                    {{ $user->role ? $user->role->name : 'Administrator' }}
                                </span>
                                <span class="text-muted extra-small"><i class="bi bi-calendar-event me-1"></i> Member since {{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-12">
                            <div class="form-section-title mb-4">
                                <h6 class="fw-bold">Contact Information</h6>
                                <div class="form-section-sep"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Full Name</label>
                            <input type="text" name="name" class="form-control-refined w-100 @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback mt-2 d-block">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-refined">Email Address</label>
                            <div class="input-group-refined">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control w-100 @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email') <div class="invalid-feedback mt-2 d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-section-title mb-4">
                                <h6 class="fw-bold">Account Security</h6>
                                <div class="form-section-sep"></div>
                            </div>
                            <div class="alert bg-light border-0 small text-muted rounded-3 mb-4">
                                <i class="bi bi-info-circle me-2 text-primary"></i> Leave the password fields blank if you do not want to change your current password.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-refined">New Password</label>
                            <input type="password" name="password" class="form-control-refined w-100 @error('password') is-invalid @enderror" placeholder="••••••••">
                            @error('password') <div class="invalid-feedback mt-2 d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-refined">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control-refined w-100" placeholder="••••••••">
                        </div>

                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-4 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-check-lg"></i>
                                <span>Update My Profile</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
