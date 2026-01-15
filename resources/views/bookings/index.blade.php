@extends('layouts.app')

@section('title', 'Booking Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Bookings & Appointments</h4>
        <p class="text-muted small">Track and manage your customer reservations.</p>
    </div>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary d-flex align-items-center px-4 py-2 rounded-3 shadow-sm">
        <i class="bi bi-calendar-plus me-2"></i> New Booking
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">Schedule / Customer</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Service & Staff</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Status</th>
                        <th class="pe-4 py-3 border-0 text-end text-muted small fw-bold text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-primary-soft rounded-3 text-center d-flex flex-column justify-content-center flex-shrink-0" style="width: 50px; height: 50px;">
                                    <span class="fw-bold small lh-1">{{ $booking->booking_at->format('d') }}</span>
                                    <span class="extra-small text-uppercase opacity-75">{{ $booking->booking_at->format('M') }}</span>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">{{ $booking->customer_name }}</div>
                                    <div class="extra-small text-muted">{{ $booking->booking_at->format('h:i A') }} • {{ $booking->booking_at->format('Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($booking->product)
                                <div class="fw-bold extra-small text-dark mb-1">
                                    <i class="bi bi-box-seam text-primary me-1"></i> {{ $booking->product->name }}
                                </div>
                            @endif
                            <div class="extra-small text-muted">
                                <i class="bi bi-person-badge me-1"></i> {{ $booking->staff ? $booking->staff->name : 'Unassigned' }}
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass = match($booking->status) {
                                    'confirmed' => 'success',
                                    'pending' => 'warning',
                                    'completed' => 'primary',
                                    'cancelled' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}-soft text-{{ $statusClass }} p-2 px-3 rounded-pill extra-small fw-bold border-0">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden border">
                                <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-white btn-sm" title="Edit">
                                    <i class="bi bi-pencil text-primary"></i>
                                </a>
                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm" title="Delete">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted mb-3">
                                <i class="bi bi-calendar-x display-1 opacity-25"></i>
                            </div>
                            <h5 class="fw-bold">No Bookings Found</h5>
                            <p class="text-muted small">No scheduled appointments for this period.</p>
                            <a href="{{ route('bookings.create') }}" class="btn btn-primary rounded-3 px-4 mt-2">Book Now</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
