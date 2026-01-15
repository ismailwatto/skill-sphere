@extends('layouts.app')

@section('title', 'Role Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">System Roles</h4>
        <p class="text-muted small">Manage roles and permissions for your staff.</p>
    </div>
    <a href="{{ route('roles.create') }}" class="btn btn-primary d-flex align-items-center">
        <i class="bi bi-plus-lg me-2"></i> Create New Role
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
                        <th class="ps-4 py-3">Role Name</th>
                        <th class="py-3">Created Date</th>
                        <th class="pe-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box bg-primary-soft me-3" style="width: 35px; height: 35px; font-size: 1rem;">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $role->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted small">
                                {{ $role->created_at->format('M d, Y') }}
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-white btn-sm border-end" title="Edit">
                                        <i class="bi bi-pencil text-primary"></i>
                                    </a>
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
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
                                <i class="bi bi-shield-slash display-4 d-block mb-3 opacity-25"></i>
                                No roles found. Create your first role to get started.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
