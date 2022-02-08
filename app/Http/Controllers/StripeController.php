<?php
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Session;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTicket;
use App\Models\Tracking;
 
class StripeController extends Controller
{
    public $gateway;
    public $completePaymentUrl;
 
    public function __construct()
    {
        $this->gateway = Omnipay::create('Stripe\PaymentIntents');
        $this->gateway->setApiKey(env('STRIPE_SECRET_KEY'));
        $this->completePaymentUrl = url('confirm');
    }
 
    public function charge(Request $request)
    {
        if($request->input('stripeToken'))
        {
            $token = $request->input('stripeToken');
            $repair_id = $request->input('repair_id');
            $pay_id = $request->input('pay_id');

            $PaymentRequest = PaymentRequest::with("user","repairPayment")->where("id", "=", $pay_id)->first();

            $response = $this->gateway->authorize([
                'amount' => $PaymentRequest->amount,
                'currency' => 'EUR',
                'description' => $PaymentRequest->repairPayment->number,
                'token' => $token,
                'returnUrl' => $this->completePaymentUrl,
                'confirm' => true,
            ])->send();
 
            if($response->isSuccessful())
            {
                $response = $this->gateway->capture([
                    'amount' => $PaymentRequest->amount,
                    'currency' => 'EUR',
                    'paymentIntentReference' => $response->getPaymentIntentReference(),
                ])->send();
 
                $arr_payment_data = $response->getData();
 
                $this->store_payment([
                    'id' => $PaymentRequest->id,
                    'payer_email' => $PaymentRequest->user->email,
                    'amount' => $PaymentRequest->amount,
                    'currency' => 'EUR',
                    'payment_status' => $arr_payment_data['status'],
                ]);
 
                return redirect("user/repair_payment/view/".$PaymentRequest->repair_id)->with("success", "Payment is successful. Your payment id is: ". $arr_payment_data['id']);
            }
            elseif($response->isRedirect())
            {
                session(['payer_email' => $PaymentRequest->user->email, 'pay_id' => $PaymentRequest->id]);
                $response->redirect();
            }
            else
            {
                return redirect("user/repair_payment/view/".$PaymentRequest->repair_id."/pay/".$PaymentRequest->id)->with("error", $response->getMessage());
            }
        }
    }
 
    public function confirm(Request $request)
    {
        $PaymentRequest = PaymentRequest::with("user")->where("id", "=", session('pay_id'))->first();

        $response = $this->gateway->confirm([
            'paymentIntentReference' => $request->input('payment_intent'),
            'returnUrl' => $this->completePaymentUrl,
        ])->send();
         
        if($response->isSuccessful())
        {
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
 
            return redirect("user/repair_payment/view/".$PaymentRequest->repair_id)->with("success", "Payment is successful. Your payment id is: ". $arr_payment_data['id']);
        }
        else
        {
            return redirect("user/repair_payment/view/".$PaymentRequest->repair_id."/pay/".$PaymentRequest->id)->with("error", $response->getMessage());
        }
    }
 
    public function store_payment($arr_data = [])
    {
        $query = PaymentRequest::with("user")->where("id", "=", $arr_data['id'])->first();

        $admin_users = User::role('admin')->where("verify", "=", "1")->get();
        if($admin_users->count()) {
            foreach ($admin_users as $adminkey => $adminvalue) {
                // Send to Admin
                $mailData = [
                    'title' => str_replace(array('{amount}','{user}'),array($query->amount,$query->user->email),trans('email.payment_paid_to_admin_title')),
                    'description' => str_replace(array('{amount}','{user}'),array($query->amount, $query->user->email),trans('email.payment_paid_to_admin_description')),
                    'button' => str_replace(array('{amount}','{user}'),array($query->amount, $query->user->email),trans('email.payment_paid_to_admin_button')),
                    'url' => 'https://euronetsupport.com/admin/repair/view/'.$arr_data['id']
                ];
                Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
                Tracking::create(["email"=>$adminvalue->email,"button"=>json_encode($mailData)]);
            }
        }


        $query->status = 1;
        $query->save();


    }
}