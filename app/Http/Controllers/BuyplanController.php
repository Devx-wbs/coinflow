<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Str;
use App\Models\License;
use App\Models\Plan;
use Carbon\Carbon;
use DB;

class BuyplanController extends Controller
{
    /**
     * Show Buy Plan Page
     */
    public function create()
    {
        return view('home-fronted.buy-plan');
    }

    /**
     * Start Stripe Checkout
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to subscribe.');
        }

        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        # Check if user already has ANY active subscription
        $existingSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if ($existingSubscription) {
            return redirect()->back()->with(
                'error',
                '⚠️ You have already purchased another plan using this account. 
                 If you want to buy a different plan, please use another account.'
            );
        }

        # Stripe Checkout
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $checkoutSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $plan->price * 100, # convert to cents
                    'product_data' => [
                        'name' => $plan->name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'customer_email' => $user->email,
            # ✅ Add session_id in success_url
            'success_url' => route('buyplan.success', ['plan_id' => $plan->id]) . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('buyplan.cancel'),
        ]);

        return redirect($checkoutSession->url);
    }

    /**
     * Handle Stripe success callback
     */
    public function success(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login again.');
        }

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $sessionId = $request->get('session_id');
            if (!$sessionId) {
                return redirect()->route('buyplan.cancel')->with('error', 'Missing session ID.');
            }

            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

            $plan = Plan::findOrFail($request->plan_id);

            DB::beginTransaction();

            # Dates
            $startDate = Carbon::now();
            $endDate = (clone $startDate)->add($plan->duration_type, (int) $plan->duration);

            # Create subscription
            $subscription = Subscription::create([
                'user_id'       => $user->id,
                'plan_id'       => $plan->id,
                'start_date'    => $startDate->toDateString(),
                'end_date'      => $endDate->toDateString(),
                'status'        => 'active',
                'transaction_id'=> $paymentIntent->id,
            ]);
            

            # Generate license
            $licenseKey = strtoupper(Str::random(8)) . '-' . $user->id . '-' . strtoupper(Str::random(6));
            

            License::create([
                'user_id'         => $user->id,
                'plan_id'         => $plan->id,
                'subscription_id' => $subscription->id,
                'license_key'     => $licenseKey,
                'store_url'       => null,
                'max_activations' => $plan->max_activations ?? 1,
                'used_activations'=> 0,
                'status'          => 'active',
                'expiration_date' => $endDate->toDateString(),
            ]);

        

            DB::commit();

            return redirect()->route('plan-detail')->with(
                'success',
                '🎉 Payment successful! Subscription activated. Your license key: ' . $licenseKey
            );
        } catch (\Exception $e) {
            DB::rollBack();
            var_dump($e->getMessage());die;
            \Log::error('Stripe success error: ' . $e->getMessage());
            return redirect()->route('buyplan.cancel')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Handle Payment Cancel
     */
    public function cancel()
    {
        return redirect('/')->with('error', '❌ Payment cancelled.');
    }
}
