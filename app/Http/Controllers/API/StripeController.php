<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class StripeController extends BaseController
{
    public function confirm(Request $request)
    {
        $PaymentRequest = PaymentRequest::with("user")->where("id", "=", session('pay_id'))->first();


            $response = $this->gateway->capture([
                'amount' => $request->input('amount'),
                'currency' => 'EUR',
                'paymentIntentReference' => $request->input('payment_intent'),
            ])->send();

            $arr_payment_data = $response->getData();

            $this->store_payment([
                'id' => $PaymentRequest->id,
                'payer_email' => session('payer_email'),
                'amount' => $PaymentRequest->amount,
                'currency' => 'EUR',
                'payment_status' => $arr_payment_data['status'],
            ]);

            $success['payment'] = $rPayment;
            return $this->sendResponse($success, 'successfully');;
    }
}
