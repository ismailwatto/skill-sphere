<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout(User $user)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        if (!$user->plan) {
            return redirect()->back()->with('error', 'User has no assigned plan to pay for.');
        }

        $priceInCents = (int) ($user->plan->price * 100);

        $checkoutData = [
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Payment for ' . $user->plan->name . ' Plan',
                        'description' => 'For user: ' . $user->name,
                    ],
                    'unit_amount' => $priceInCents,
                ],
                'quantity' => 1,
            ]],

            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('businesses.index'),
            'metadata' => [
                'user_id' => $user->id,
            ],
        ];

        if ($user->stripe_customer_id) {
            $checkoutData['customer'] = $user->stripe_customer_id;
        } else {
            $checkoutData['customer_email'] = $user->email;
            $checkoutData['customer_creation'] = 'always';
        }

        $session = Session::create($checkoutData);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            try {
                $session = Session::retrieve($sessionId);
                if ($session->payment_status == 'paid') {
                     $userId = $session->metadata->user_id ?? null;
                     if ($userId) {
                         $user = User::find($userId);
                         if ($user) {
                             $updateData = ['payment_status' => 'paid'];
                             
                             // Also capture customer ID if we didn't have it before
                             if (!$user->stripe_customer_id && $session->customer) {
                                 $updateData['stripe_customer_id'] = $session->customer;
                             }
                             
                             $user->update($updateData);
                         }
                     }
                }
            } catch (\Exception $e) {
                // Ignore error, fallback to webhook
            }
        }

        return redirect()->route('businesses.index')->with('success', 'Payment successful!');
    }
}
