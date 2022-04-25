<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;


class StripeController extends Controller
{
    public function stripePost(Request $request)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try{
            $token = $stripe->tokens()->create([
                'card' => [
                    'number'    => $request->card_number,
                    'exp_month' => $request->card_expiry_month,
                    'exp_year'  => $request->card_expiry_year,
                    'cvc'       => $request->card_cvc,
                ],
            ]);
            return response()->json(['token' => $token]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
        if(!$token['id']){
            session()->flash('error', 'Stripe token genration failed');
        }
    }


    public function createCustomer(Request $request)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try{
            $customer = $stripe->customers()->create([
                'customer' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    "address"=>[
                        "city"=> $request->address["city"],
                        "country"=> "EG",
                        "line1"=> $request->address["address"],
                        "line2"=> null,
                        "postal_code"=> $request->address["postal_code"],
                        "state"=> null
                    ],
                ],
            ]);
            return response()->json(['success' => true, 'customer' => $customer]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
        if(!$customer['id']){
            session()->flash('error', 'Stripe customer creation failed');
        }
    }

    public function createCharge(Request $request)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try{
            // return $request->customer;
            $charge = $stripe->charges()->create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $request->source,
                'description' => 'My First Test Charge (created for API docs)',
            ]);
            return response()->json(['success' => true]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
        if(!$charge['id']){
            session()->flash('error', 'Stripe charing '. $request->customer .' for '. $request->amount .' failed');
        }
    }

    public function createRefund(Request $request)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try{
            $refund = $stripe->refunds()->create([
                'charge' => $request->charge,
                'amount' => $request->amount,
            ]);
            return response()->json(['success' => true]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
        if(!$refund['id']){
            session()->flash('error', 'Stripe refundnig '. $request->customer .' for '. $request->amount .' failed');
        }
    }

    public function createInvoice(Request $request)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try{
            $invoice = $stripe->invoices()->create([
                'customer' => $request->customer,
                'auto_advance' => true,
                'collection_method' => 'send_invoice',
                'days_until_due' => 30,
                'description' => 'Order #' . $request->order_id,
                'statement_descriptor' => 'Order #' . $request->order_id,
                'subscription' => $request->subscription,
            ]);
            return response()->json(['success' => true]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
        if(!$invoice['id']){
            session()->flash('error', 'Stripe invoice creation failed');
        }
    }

    public function createPaymentMethod(Request $request)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try{
            $paymentMethod = $stripe->paymentMethods()->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->month,
                    'exp_year' => $request->year,
                    'cvc' => $request->cvc,
                ],
            ]);
            return response()->json(['success' => true]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
        if(!$paymentMethod['id']){
            session()->flash('error', 'Stripe payment method creation failed');
        }
    }

    public function createSubscription(Request $request)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try{
            $subscription = $stripe->subscriptions()->create([
                'customer' => $request->customer,
                'items' => [['plan' => $request->plan]],
            ]);
            return response()->json(['success' => true]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
        if(!$subscription['id']){
            session()->flash('error', 'Stripe subscription creation failed');
        }
    }
}
