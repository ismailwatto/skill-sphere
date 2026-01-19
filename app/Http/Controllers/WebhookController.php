<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\User;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Log::info('Webhook received'); // Optional logging
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Webhook error: Invalid payload');
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Webhook error: Invalid signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            default:
                // Log::info('Received unknown event type ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        Log::info('Handling checkout.session.completed', ['session_id' => $session->id]);
        
        $customerId = $session->customer;
        $userId = $session->metadata->user_id ?? null;

        if ($userId && $customerId) {
            $user = User::find($userId);
            if ($user) {
                // Check if user already has a customer ID or just update it
                $user->stripe_customer_id = $customerId;
                $user->payment_status = 'paid';
                $user->save();
                Log::info('Updated user stripe customer ID and payment status', ['user_id' => $user->id, 'customer_id' => $customerId]);
            }
        }
    }
}
