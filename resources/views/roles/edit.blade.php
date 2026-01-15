@extends('layouts.app')

@section('title', 'Edit Role: ' . $role->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}" class="text-decoration-none text-muted small">Access Roles</a></li>
                        <li class="breadcrumb-item active small" aria-current="page">Modify Role</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Update Role Details</h3>
            </div>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-bold small">
                <i class="bi bi-x-lg me-2"></i> Cancel
            </a>
        </div>

        <form action="{{ route('roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="form-section-title mb-4">
                        <div class="icon-box bg-primary-soft rounded-3" style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h6 class="fw-bold">Role Configuration</h6>
                        <div class="form-section-sep"></div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label-refined">Display Name</label>
                        <input type="text" name="name" class="form-control-refined w-100 @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" required>
                        @error('name') <div class="invalid-feedback mt-2 d-block">{{ $message }}</div> @enderror
                        <p class="text-muted extra-small mt-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i> Changing this will affect all staff members currently assigned to this role.
                        </p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-4 fw-bold shadow-sm d-flex align-items-center gap-2 w-100 justify-content-center">
                            <i class="bi bi-save"></i>
                            <span>Save Role Changes</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
