<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    // payment page
    public function create(Property $property)
    {
        // Ensure property is available
        if (!$property->isPublished()) {
            abort(404, 'Property not available');
        }

        // Check if user has confirmed appointment
        $confirmedAppointment = $property->appointments()
            ->where('client_id', Auth::id())
            ->where('status', 'confirmed')
            ->latest()
            ->first();

        if (!$confirmedAppointment) {
            return redirect()->route('properties.show', $property)
                ->with('error', 'You need to have a confirmed appointment before proceeding to payment.');
        }

        return view('payments.create', compact('property', 'confirmedAppointment'));
    }

    // checkout dyal payment
    public function createCheckoutSession(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'payment_type' => 'required|in:monthly_rent,full_purchase',
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            // convert MAD to USD for testing
            $amountInUSD = $validated['amount'] / 10;
            $amountInCents = $amountInUSD * 100;

            // Create Stripe checkout session
            if ($validated['payment_type'] === 'monthly_rent') {
                // ! mybe rada thayed
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $property->title . ' - Monthly Rent',
                                'description' => 'Monthly rental payment for ' . $property->title,
                            ],
                            'unit_amount' => $amountInCents,
                            'recurring' => [
                                'interval' => 'month',
                            ],
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'success_url' => route('payments.success', [
                        'property' => $property->id,
                        'session_id' => '{CHECKOUT_SESSION_ID}'
                    ]),
                    'cancel_url' => route('payments.create', $property),
                    'metadata' => [
                        'property_id' => $property->id,
                        'client_id' => Auth::id(),
                        'payment_type' => $validated['payment_type'],
                    ],
                ]);
            } else {
                // Create one-time payment for purchase
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $property->title,
                                'description' => 'Full Property Purchase - ' . $property->title,
                            ],
                            'unit_amount' => $amountInCents,
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => route('payments.success', [
                        'property' => $property->id,
                        'session_id' => '{CHECKOUT_SESSION_ID}'
                    ]),
                    'cancel_url' => route('payments.create', $property),
                    'metadata' => [
                        'property_id' => $property->id,
                        'client_id' => Auth::id(),
                        'payment_type' => $validated['payment_type'],
                    ],
                ]);
            }

            // Store payment record
            Payment::create([
                'client_id' => Auth::id(),
                'owner_id' => $property->owner_id,
                'property_id' => $property->id,
                'amount' => $validated['amount'],
                'payment_type' => $validated['payment_type'],
                'status' => 'pending',
                'stripe_session_id' => $session->id,
            ]);

            return redirect($session->url);

        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage(), [
                'property_id' => $property->id,
                'client_id' => Auth::id(),
                'payment_type' => $validated['payment_type'] ?? null,
                'amount' => $validated['amount'] ?? null,
                'exception' => $e
            ]);

            return back()->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Request $request, Property $property): View
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            abort(404);
        }

        // Find payment record
        $payment = Payment::where('stripe_session_id', $sessionId)
            ->where('property_id', $property->id)
            ->where('client_id', Auth::id())
            ->first();

        if (!$payment) {
            abort(404);
        }

        
        if ($payment->status === 'pending') {
            try {
                $session = Session::retrieve($sessionId);

                if ($payment->payment_type === 'monthly_rent') {
                    
                    if ($session->subscription) {
                        $payment->update([
                            'status' => 'completed',
                            'stripe_subscription_id' => $session->subscription,
                            'paid_at' => now(),
                        ]);

                        
                        $property->update(['status' => 'rented']);
                    }
                } else {
                    
                    if ($session->payment_status === 'paid') {
                        $payment->update([
                            'status' => 'completed',
                            'stripe_payment_intent_id' => $session->payment_intent,
                            'paid_at' => now(),
                        ]);

                        
                        if ($payment->payment_type === 'full_purchase') {
                            $property->update(['status' => 'sold']);
                        }
                    }
                }
            } catch (\Exception $e) {
                
                Log::error('Error updating payment status: ' . $e->getMessage());
            }
        }

        return view('payments.success', compact('payment', 'property'));
    }
}
