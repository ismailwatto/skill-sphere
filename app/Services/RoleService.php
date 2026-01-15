<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    /**
     * Get all roles for the authenticated user's business.
     */
    public function getBusinessRoles(): Collection
    {
        $businessId = Auth::user()->business_id;
        
        // If super admin (no business_id), they might see all or system roles.
        // For now, let's scope to business_id.
        return Role::where('business_id', $businessId)->get();
    }

    /**
     * Create a new role for the business.
     */
    public function createRole(array $data): Role
    {
        return Role::create([
            'business_id' => Auth::user()->business_id,
            'name' => $data['name'],
        ]);
    }

    /**
     * Update an existing role.
     */
    public function updateRole(Role $role, array $data): bool
    {
        // Ensure the role belongs to the same business
        if ($role->business_id !== Auth::user()->business_id) {
            return false;
        }

        return $role->update([
            'name' => $data['name'],
        ]);
    }

    /**
     * Delete a role.
     */
    public function deleteRole(Role $role): bool
    {
        if ($role->business_id !== Auth::user()->business_id) {
            return false;
        }

        return $role->delete();
    }
}
