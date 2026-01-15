<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Validate user status and business subscription.
     *
     * @param User $user
     * @return void
     * @throws ValidationException
     */
    public function validateUserStatus(User $user): void
    {
        // 1. Check User Status
        if ($user->status !== 'active') {
            $this->failLogout('Your account is inactive.');
        }

        // 2. Check Business Status (if not Super Admin)
        if ($user->business_id) {
            $business = $user->business;
            
            if (!$business) {
                // Orphaned user?
               $this->failLogout('No business associated with this account.');
            }

            if ($business->status !== 'active') {
                $this->failLogout('Your company account is inactive.');
            }

            // 3. Check Subscription
            if ($business->subscription_status !== 'active' && $business->subscription_status !== 'trial') {
                $this->failLogout('Your company subscription has expired.');
            }
        }
    }

    /**
     * Logout and throw exception.
     */
    protected function failLogout(string $message): void
    {
        Auth::logout();
        throw ValidationException::withMessages([
            'email' => $message,
        ]);
    }
}
