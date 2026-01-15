@extends('layouts.app')

@section('title', 'Create Booking')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}" class="text-decoration-none text-muted small">Schedule</a></li>
                        <li class="breadcrumb-item active small" aria-current="page">New Appointment</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Book Appointment</h3>
            </div>
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-bold small">
                <i class="bi bi-x-lg me-2"></i> Cancel
            </a>
        </div>

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <!-- Customer Section -->
                    <div class="form-section-title mb-4">
                        <div class="icon-box bg-primary-soft rounded-3" style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <i class="bi bi-person"></i>
                        </div>
                        <h6 class="fw-bold">Customer Profile</h6>
                        <div class="form-section-sep"></div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-12">
                            <label class="form-label-refined">Full Name</label>
                            <input type="text" name="customer_name" class="form-control-refined w-100 @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" placeholder="Enter customer name" required>
                            @error('customer_name') <div class="invalid-feedback mt-2">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Email Address</label>
                            <div class="input-group-refined">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="customer_email" class="form-control w-100" value="{{ old('customer_email') }}" placeholder="customer@example.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Phone Number</label>
                            <div class="input-group-refined">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="customer_phone" class="form-control w-100" value="{{ old('customer_phone') }}" placeholder="+1 (555) 000-0000">
                            </div>
                        </div>
                    </div>

                    <!-- Service Section -->
                    <div class="form-section-title mb-4">
                        <div class="icon-box bg-success-soft rounded-3" style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h6 class="fw-bold">Service & Staff</h6>
                        <div class="form-section-sep"></div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label-refined">Select Product / Service</label>
                            <select name="product_id" class="form-control-refined w-100">
                                <option value="">No Product Selected</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (${{ number_format($product->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Assign Staff Member</label>
                            <select name="user_id" class="form-control-refined w-100">
                                <option value="">Unassigned</option>
                                @foreach($staff as $member)
                                    <option value="{{ $member->id }}" {{ old('user_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Date & Time</label>
                            <input type="datetime-local" name="booking_at" class="form-control-refined w-100 @error('booking_at') is-invalid @enderror" value="{{ old('booking_at') }}" required>
                            @error('booking_at') <div class="invalid-feedback mt-2">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Initial Status</label>
                            <select name="status" class="form-control-refined w-100">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label-refined">Notes (Internal)</label>
                            <textarea name="notes" class="form-control-refined w-100" rows="3" placeholder="Any special requirements?">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-calendar-check"></i>
                            <span>Confirm Appointment</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
