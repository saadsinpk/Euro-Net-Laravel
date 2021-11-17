<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Stripe;
use Session;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTicket;

class StripeController extends Controller
{
 
    /**
     * handling payment with POST
     */

    public function handlePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => (int) $_POST['amount'] * 100,
                "currency" => "EUR",
                "source" => $_POST['stripeToken'],
                "description" => "Euronet Ticket- (".$_POST['ticketid'].")"
        ]);
        $query = PaymentRequest::find($_POST['id']);
        // $user = User::find($query->user_id);

        $admin_users = User::role('admin')->where("verify", "=", "1")->get();
        if($admin_users->count()) {
            foreach ($admin_users as $adminkey => $adminvalue) {
                // Send to Admin
                $mailData = [
                    'title' => str_replace('{amount}',$_POST['amount'],trans('email.payment_paid_to_admin_title')),
                    'description' => str_replace('{amount}',$_POST['amount'],trans('email.payment_paid_to_admin_description')),
                    'button' => str_replace('{amount}',$_POST['amount'],trans('email.payment_paid_to_admin_button')),
                    'url' => 'https://euronetsupport.com/admin/repair/view/'.$_POST['id']
                ];
                Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
            }
        }


        $query->status = 1;
        $query->save();

        return response()->json(200);
    }
}