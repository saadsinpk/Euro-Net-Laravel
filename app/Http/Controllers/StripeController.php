<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Stripe;
use Session;
use App\Models\PaymentRequest;

class StripeController extends Controller
{
 
    /**
     * handling payment with POST
     */

    public function handlePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => (int) $request->amount * 100,
                "currency" => "inr",
                "source" => $request->stripeToken,
                "description" => "Making test payment." 
        ]);
  
        $query = PaymentRequest::find($request->id);
        $query->status = 1;
        $query->save();

        return response()->json(200);
    }
}