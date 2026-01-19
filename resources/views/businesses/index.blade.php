@extends('layouts.app')

@section('title', 'Manage Businesses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Business Directory</h4>
        <p class="text-muted small">Manage all registered businesses and their owner accounts.</p>
    </div>
    <a href="{{ route('businesses.create') }}" class="btn btn-primary px-4 py-2 rounded-3 fw-bold shadow-sm">
        <i class="bi bi-plus-lg me-2"></i> Register New Business
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">Business Name</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Owner / Customer</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Type</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Status</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Subscription</th>
                        <th class="pe-4 py-3 border-0 text-end text-muted small fw-bold text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($businesses as $business)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-primary-soft" style="width: 40px; height: 40px; font-size: 1rem;">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $business->name }}</div>
                                    <div class="extra-small text-muted">{{ $business->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($business->owner)
                                <div class="fw-bold small">{{ $business->owner->name }}</div>
                                <div class="extra-small text-muted">{{ $business->owner->email }}</div>
                            @else
                                <span class="text-danger small">No Owner Assigned</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border p-2 px-3 rounded-pill extra-small fw-bold">
                                {{ ucfirst($business->type ?? 'General') }}
                            </span>
                        </td>
                        <td>
                            @if($business->status == 'active')
                                <span class="badge bg-success-soft p-2 px-3 rounded-pill extra-small fw-bold border-0">Active</span>
                            @else
                                <span class="badge bg-danger-soft p-2 px-3 rounded-pill extra-small fw-bold border-0">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($business->owner && $business->owner->plan)
                                <div class="fw-bold small">{{ $business->owner->plan->name }}</div>
                                <div class="extra-small text-muted">${{ number_format($business->owner->plan->price, 2) }}</div>
                                <div class="mt-1">
                                    @if($business->owner->payment_status == 'paid')
                                        <span class="badge bg-success-soft text-success border border-success border-opacity-25 rounded-pill px-2 py-1 extra-small">
                                            <i class="bi bi-check-circle me-1"></i> Paid
                                        </span>
                                    @elseif($business->owner->payment_status == 'pending')
                                        <span class="badge bg-warning-soft text-warning border border-warning border-opacity-25 rounded-pill px-2 py-1 extra-small">
                                            <i class="bi bi-clock me-1"></i> Pending
                                        </span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1 extra-small">
                                            <i class="bi bi-x-circle me-1"></i> {{ ucfirst($business->owner->payment_status ?? 'Unpaid') }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted small">No Plan</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    @if($business->owner)
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('payment.checkout', $business->owner->id) }}">
                                                <i class="bi bi-credit-card me-2 text-success"></i> Make Payment
                                            </a>
                                        </li>
                                    @endif
                                    <li><a class="dropdown-item py-2" href="{{ route('businesses.edit', $business->id) }}"><i class="bi bi-pencil me-2"></i> Edit Details</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('businesses.destroy', $business->id) }}" method="POST" onsubmit="return confirm('Change status for this business?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-2 {{ $business->status == 'active' ? 'text-danger' : 'text-success' }}">
                                                <i class="bi {{ $business->status == 'active' ? 'bi-slash-circle' : 'bi-check-circle' }} me-2"></i> 
                                                {{ $business->status == 'active' ? 'Deactivate' : 'Reactivate' }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted mb-3">
                                <i class="bi bi-building-exclamation display-4"></i>
                            </div>
                            <div class="fw-bold h5">No Businesses Found</div>
                            <p class="text-muted small">Start by registering your first customer business.</p>
                            <a href="{{ route('businesses.create') }}" class="btn btn-primary rounded-3 px-4 mt-2">
                                New Registration
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
