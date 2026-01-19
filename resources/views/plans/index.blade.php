@extends('layouts.app')

@section('title', 'Plan Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Plans</h4>
        <p class="text-muted small">Manage subscription plans.</p>
    </div>
    <a href="{{ route('plans.create') }}" class="btn btn-primary d-flex align-items-center">
        <i class="bi bi-plus-lg me-2"></i> Add New Plan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Name</th>
                        <th class="py-3">Price</th>
                        <th class="py-3">Description</th>
                        <th class="pe-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $plan->name }}</td>
                            <td>${{ number_format($plan->price, 2) }}</td>
                            <td class="text-muted small">{{ Str::limit($plan->description, 50) }}</td>
                            <td class="pe-4 text-end">
                                <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                    <a href="{{ route('plans.edit', $plan) }}" class="btn btn-white btn-sm border-end" title="Edit">
                                        <i class="bi bi-pencil text-primary"></i>
                                    </a>
                                    <form action="{{ route('plans.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
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
                            <td colspan="4" class="text-center py-5 text-muted">
                                No plans found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
