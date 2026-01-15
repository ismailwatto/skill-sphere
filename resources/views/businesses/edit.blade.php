@extends('layouts.app')

@section('title', 'Edit Business')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('businesses.index') }}" class="text-decoration-none text-muted small">Businesses</a></li>
                        <li class="breadcrumb-item active small" aria-current="page">Update Profile</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Modify Business</h3>
                <p class="text-muted small mb-0 font-monospace">Authorized Rep: {{ $business->email }}</p>
            </div>
            <a href="{{ route('businesses.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-bold small">
                <i class="bi bi-x-lg me-2"></i> Cancel
            </a>
        </div>

        <form action="{{ route('businesses.update', $business->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="form-section-title mb-4">
                        <div class="icon-box bg-primary-soft rounded-3" style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <i class="bi bi-building-gear"></i>
                        </div>
                        <h6 class="fw-bold">General Information</h6>
                        <div class="form-section-sep"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label-refined">Legal Entity Name</label>
                            <div class="input-group-refined">
                                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                <input type="text" name="business_name" class="form-control w-100 @error('business_name') is-invalid @enderror" placeholder="Enter business name" value="{{ old('business_name', $business->name) }}" required>
                            </div>
                            @error('business_name') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-refined">Industry / Type</label>
                            <select name="business_type" class="form-control-refined w-100">
                                <option value="retail" {{ $business->type == 'retail' ? 'selected' : '' }}>Retail & Commerce</option>
                                <option value="service" {{ $business->type == 'service' ? 'selected' : '' }}>Service & Consulting</option>
                                <option value="agency" {{ $business->type == 'agency' ? 'selected' : '' }}>Agency & Marketing</option>
                                <option value="saas" {{ $business->type == 'saas' ? 'selected' : '' }}>Software & Technology</option>
                                <option value="healthcare" {{ $business->type == 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                                <option value="education" {{ $business->type == 'education' ? 'selected' : '' }}>Education</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-refined">Contact Number</label>
                            <div class="input-group-refined">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="business_phone" class="form-control w-100" placeholder="Primary contact" value="{{ old('business_phone', $business->phone) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-refined">Account Status</label>
                            <select name="status" class="form-control-refined w-100 @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $business->status) == 'active' ? 'selected' : '' }}>Active Account</option>
                                <option value="inactive" {{ old('status', $business->status) == 'inactive' ? 'selected' : '' }}>Inactive / Deactivated</option>
                            </select>
                            @error('status') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label-refined">Registered Address</label>
                            <textarea name="business_address" class="form-control-refined w-100 @error('business_address') is-invalid @enderror" rows="4" placeholder="Full business location address">{{ old('business_address', $business->address) }}</textarea>
                            @error('business_address') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="pt-5 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-save"></i>
                            <span>Save Business Changes</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
