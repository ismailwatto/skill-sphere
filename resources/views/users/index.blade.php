@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Staff & Users</h4>
        <p class="text-muted small">Manage your team members and their account status.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center">
        <i class="bi bi-person-plus me-2"></i> Add New User
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">User</th>
                        <th class="py-3">Role</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Joined</th>
                        <th class="pe-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" alt="avatar" class="rounded-circle me-3" width="40" height="40">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->role)
                                    <span class="badge rounded-pill bg-primary-soft text-primary fw-semibold">
                                        {{ $user->role->name }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary-soft text-secondary fw-semibold">
                                        No Role
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge rounded-pill bg-success-soft text-success badge-soft">Active</span>
                                @else
                                    <span class="badge rounded-pill bg-danger-soft text-danger badge-soft">Inactive</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-white btn-sm border-end" title="Edit">
                                        <i class="bi bi-pencil text-primary"></i>
                                    </a>
                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-white btn-sm" title="Delete">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people display-4 d-block mb-3 opacity-25"></i>
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
