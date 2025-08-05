<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $payments = Payment::with('property')
            ->where('owner_id', Auth::id())
            ->latest()
            ->paginate(10);

        $stats = [
            'total_paid' => Payment::where('owner_id', Auth::id())->where('status', 'completed')->sum('amount'),
            'pending_payments' => Payment::where('owner_id', Auth::id())->where('status', 'pending')->sum('amount'),
            'transactions_count' => Payment::where('owner_id', Auth::id())->count(),
            'commission_rate' => 5, // 5% dyal commission
        ];

        return view('owner.payments.index', compact('payments', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $property = null;

        if ($request->has('property')) {
            $property = Property::where('id', $request->property)
                ->where('owner_id', Auth::id())
                ->where('status', 'approved')
                ->where('payment_completed', false)
                ->first();

            if (!$property) {
                return redirect()->route('owner.properties.index')
                    ->with('error', 'Property not found or payment not required.');
            }
        }

        // Get all properties that need payment
        $propertiesNeedingPayment = Property::where('owner_id', Auth::id())
            ->where('status', 'approved')
            ->where('payment_completed', false)
            ->get();

        return view('owner.payments.create', compact('property', 'propertiesNeedingPayment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // checkout dyal payment
    public function createCheckoutSession(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        $property = Property::where('id', $validated['property_id'])
            ->where('owner_id', Auth::id())
            ->where('status', 'approved')
            ->where('payment_completed', false)
            ->first();

        if (!$property) {
            return back()->with('error', 'Property not found or payment not required.');
        }

        // Calculate 5% 
        $amount = $property->price * 0.05;
        $amountInCents = (int) ($amount * 100); // Convert to cents for Stripe

        try {
            // Create payment record
            $payment = Payment::create([
                'owner_id' => Auth::id(),
                'property_id' => $property->id,
                'amount' => $amount,
                'fee_percentage' => 5.0,
                'status' => 'pending',
            ]);

            // Create Stripe checkout session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'mad',
                        'product_data' => [
                            'name' => 'Property Listing Fee - ' . $property->title,
                            'description' => '5% listing fee for property publication',
                        ],
                        'unit_amount' => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('owner.payments.success', ['payment' => $payment->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('owner.payments.cancel', ['payment' => $payment->id]),
                'metadata' => [
                    'payment_id' => $payment->id,
                    'property_id' => $property->id,
                    'owner_id' => Auth::id(),
                ],
            ]);

            // Update payment with Stripe session ID
            $payment->update([
                'stripe_payment_intent_id' => $session->id,
            ]);

            return redirect($session->url);

        } catch (ApiErrorException $e) {
            return back()->with('error', 'Payment processing error: ' . $e->getMessage());
        }
    }

    // success payment
    public function success(Request $request, Payment $payment): RedirectResponse
    {
        
        if ($payment->owner_id !== Auth::id()) {
            abort(403);
        }

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('owner.payments.index')
                ->with('error', 'Invalid payment session.');
        }

        try {
            
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                
                $payment->update([
                    'status' => 'completed',
                    'stripe_charge_id' => $session->payment_intent,
                    'stripe_response' => $session->toArray(),
                    'paid_at' => now(),
                ]);

                // property is paid and now it's live
                $property = $payment->property;
                $property->update([
                    'payment_completed' => true,
                    'published_at' => now(),
                ]);

                return redirect()->route('owner.properties.show', $property)
                    ->with('success', 'Payment successful! Your property is now live.');
            } else {
                return redirect()->route('owner.payments.index')
                    ->with('error', 'Payment was not completed successfully.');
            }

        } catch (ApiErrorException $e) {
            return redirect()->route('owner.payments.index')
                ->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }

    // cancel payment
    public function cancel(Payment $payment): RedirectResponse
    {
        
        if ($payment->owner_id !== Auth::id()) {
            abort(403);
        }

        
        $payment->update([
            'status' => 'failed',
            'failure_reason' => 'Payment cancelled by user',
        ]);

        return redirect()->route('owner.payments.create', ['property' => $payment->property_id])
            ->with('error', 'Payment was cancelled. You can try again when ready.');
    }

    // webhook
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
            default:
                // Unexpected event type
                break;
        }

        return response('Webhook handled', 200);
    }

    // handle checkout session completed
    private function handleCheckoutSessionCompleted($session)
    {
        $paymentId = $session->metadata->payment_id ?? null;

        if ($paymentId) {
            $payment = Payment::find($paymentId);

            if ($payment && $payment->status === 'pending') {
                $payment->update([
                    'status' => 'completed',
                    'stripe_charge_id' => $session->payment_intent,
                    'stripe_response' => $session->toArray(),
                    'paid_at' => now(),
                ]);

                // Mark property as payment completed and publish it
                $property = $payment->property;
                $property->update([
                    'payment_completed' => true,
                    'published_at' => now(),
                ]);
            }
        }
    }
}
