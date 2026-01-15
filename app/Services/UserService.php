<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /**
     * Get all users for the authenticated user's business.
     */
    public function getBusinessUsers(): Collection
    {
        return User::where('business_id', Auth::user()->business_id)->with('role')->get();
    }

    /**
     * Create a new user for the business.
     */
    public function createUser(array $data): User
    {
        return User::create([
            'business_id' => Auth::user()->business_id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
    }

    /**
     * Update an existing user.
     */
    public function updateUser(User $user, array $data): bool
    {
        if ($user->business_id !== Auth::user()->business_id) {
            return false;
        }

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'] ?? null,
            'status' => $data['status'] ?? 'active',
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        return $user->update($updateData);
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user): bool
    {
        if ($user->business_id !== Auth::user()->business_id || $user->id === Auth::id()) {
            return false;
        }

        return $user->delete();
    }
}
