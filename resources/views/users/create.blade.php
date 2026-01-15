@extends('layouts.app')

@section('title', 'Add New User')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none text-muted small">Staff Members</a></li>
                        <li class="breadcrumb-item active small" aria-current="page">New Account</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Create Staff Account</h3>
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-bold small">
                <i class="bi bi-x-lg me-2"></i> Cancel
            </a>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="form-section-title mb-4">
                        <div class="icon-box bg-primary-soft rounded-3" style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <h6 class="fw-bold">Profile Details</h6>
                        <div class="form-section-sep"></div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-12">
                            <label class="form-label-refined">Full Name</label>
                            <input type="text" name="name" class="form-control-refined w-100 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="John Doe" required>
                            @error('name') <div class="invalid-feedback mt-2">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label-refined">Email Address</label>
                            <div class="input-group-refined">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control w-100 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="staff@example.com" required>
                            </div>
                            @error('email') <div class="invalid-feedback mt-2 d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Authorization Section -->
                    <div class="form-section-title mb-4">
                        <div class="icon-box bg-success-soft rounded-3" style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h6 class="fw-bold">Security & Roles</h6>
                        <div class="form-section-sep"></div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label-refined">System Role</label>
                            <select name="role_id" class="form-control-refined w-100 @error('role_id') is-invalid @enderror">
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id') <div class="invalid-feedback mt-2 d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Account Status</label>
                            <select name="status" class="form-control-refined w-100">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active Account</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Initial Password</label>
                            <input type="password" name="password" class="form-control-refined w-100 @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            @error('password') <div class="invalid-feedback mt-2 d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control-refined w-100" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-person-check"></i>
                            <span>Create Staff Account</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
