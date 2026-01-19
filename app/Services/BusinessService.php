<?php

namespace App\Services;

use App\Models\Business;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BusinessService
{
    /**
     * Create a new business along with its primary owner account.
     *
     * @param array $data
     * @return Business
     */
    public function createBusinessWithOwner(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Create the Business
            $business = Business::create([
                'name' => $data['business_name'],
                'type' => $data['business_type'] ?? null,
                'email' => $data['owner_email'], // Business email same as owner for now
                'phone' => $data['business_phone'] ?? null,
                'address' => $data['business_address'] ?? null,
                'status' => 'active',
                'subscription_status' => 'active',
                'subscription_ends_at' => now()->addYear(),
            ]);

            // 2. Find the "Business Owner" Role
            $ownerRole = Role::where('name', 'Business Owner')->first();

            // 3. Create the Owner User
            $user = User::create([
                'business_id' => $business->id,
                'role_id' => $ownerRole->id ?? null,
                'name' => $data['owner_name'],
                'email' => $data['owner_email'],
                'password' => Hash::make($data['owner_password']),
                'plan_id' => $data['plan_id'] ?? null,
                'status' => 'active',
            ]);

            return $business;
        });
    }

    /**
     * Update business details.
     */
    public function updateBusiness(int $id, array $data)
    {
        $business = Business::findOrFail($id);
        $business->update([
            'name' => $data['business_name'],
            'type' => $data['business_type'],
            'phone' => $data['business_phone'],
            'address' => $data['business_address'],
            'status' => $data['status'] ?? $business->status,
        ]);

        // Update Owner Plan if provided
        // Update Owner Plan if provided (using array_key_exists to handle null values)
        if (array_key_exists('plan_id', $data)) {
            $owner = User::where('business_id', $business->id)
                ->whereHas('role', function($q) {
                    $q->where('name', 'Business Owner');
                })->first();
            
            // Fallback: If no user with "Business Owner" role, take the first user created for this business.
            if (!$owner) {
                $owner = User::where('business_id', $business->id)->orderBy('id')->first();
            }

            if ($owner) {
                $owner->update(['plan_id' => $data['plan_id']]);
            }
        }

        return $business;
    }

    /**
     * Toggle business active/inactive status.
     */
    public function toggleStatus(int $id)
    {
        $business = Business::findOrFail($id);
        $business->status = ($business->status === 'active') ? 'inactive' : 'active';
        $business->save();
        return $business;
    }

    /**
     * Get all businesses with their primary owner (first user with Owner role).
     */
    public function getAllBusinesses()
    {
        return Business::orderBy('created_at', 'desc')->get()->map(function($business) {
            $business->owner = User::where('business_id', $business->id)
                ->whereHas('role', function($q) {
                    $q->where('name', 'Business Owner');
                })
                ->with('plan')
                ->first();
            return $business;
        });
    }
}
