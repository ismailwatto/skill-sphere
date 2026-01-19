@extends('layouts.app')

@section('title', 'Onboard New Business')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-11 col-xxl-10">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('businesses.index') }}" class="text-decoration-none text-muted small">Businesses</a></li>
                        <li class="breadcrumb-item active small" aria-current="page">New Registration</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Business Onboarding</h3>
                <p class="text-muted small mb-0">Transform a customer into a business partner with ease.</p>
            </div>
            <a href="{{ route('businesses.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-bold small">
                <i class="bi bi-x-lg me-2"></i> Cancel
            </a>
        </div>

        <form action="{{ route('businesses.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4 p-md-5">
                            <div class="form-section-title mb-4">
                                <div class="icon-box bg-primary-soft rounded-3" style="width: 32px; height: 32px; font-size: 0.9rem;">
                                    <i class="bi bi-building"></i>
                                </div>
                                <h6 class="fw-bold">Business Profile</h6>
                                <div class="form-section-sep"></div>
                            </div>

                            <div class="row g-4 mb-5">
                                <div class="col-12">
                                    <label class="form-label-refined">Legal Entity Name</label>
                                    <div class="input-group-refined">
                                        <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                        <input type="text" name="business_name" class="form-control w-100 @error('business_name') is-invalid @enderror" placeholder="Enter business name" value="{{ old('business_name') }}" required>
                                    </div>
                                    @error('business_name') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-refined">Industry / Type</label>
                                    <select name="business_type" class="form-control-refined w-100">
                                        <option value="retail">Retail & Commerce</option>
                                        <option value="service" selected>Service & Consulting</option>
                                        <option value="agency">Agency & Marketing</option>
                                        <option value="saas">Software & Technology</option>
                                        <option value="healthcare">Healthcare</option>
                                        <option value="education">Education</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-refined">Contact Number</label>
                                    <div class="input-group-refined">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" name="business_phone" class="form-control w-100" placeholder="Primary contact" value="{{ old('business_phone') }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label-refined">Registered Address</label>
                                    <textarea name="business_address" class="form-control-refined w-100 @error('business_address') is-invalid @enderror" rows="4" placeholder="Full business location address">{{ old('business_address') }}</textarea>
                                    @error('business_address') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="form-section-title mb-4">
                                <div class="icon-box bg-success-soft rounded-3" style="width: 32px; height: 32px; font-size: 0.9rem;">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <h6 class="fw-bold">Owner Access</h6>
                                <div class="form-section-sep"></div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label-refined">Owner Name</label>
                                    <input type="text" name="owner_name" class="form-control-refined w-100 @error('owner_name') is-invalid @enderror" placeholder="Full name" value="{{ old('owner_name') }}" required>
                                    @error('owner_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label-refined">Login Email</label>
                                    <input type="email" name="owner_email" class="form-control-refined w-100 @error('owner_email') is-invalid @enderror" placeholder="owner@company.com" value="{{ old('owner_email') }}" required>
                                    @error('owner_email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label-refined">Temporary Password</label>
                                    <input type="password" name="owner_password" class="form-control-refined w-100 @error('owner_password') is-invalid @enderror" placeholder="Min 8 characters" required>
                                    @error('owner_password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12">
                                    <input type="password" name="owner_password_confirmation" class="form-control-refined w-100" placeholder="Repeat password" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label-refined">Subscription Plan</label>
                                    <select name="plan_id" class="form-control-refined w-100 @error('plan_id') is-invalid @enderror">
                                        <option value="">Select a plan</option>
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                                {{ $plan->name }} (${{ number_format($plan->price, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('plan_id') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="alert bg-light border-0 rounded-4 p-3 mt-4 small mb-0">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-info-circle text-primary"></i>
                                    <p class="text-muted mb-0 lh-sm">The owner will use these credentials for initial login and setup.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <span>Register & Onboard</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
