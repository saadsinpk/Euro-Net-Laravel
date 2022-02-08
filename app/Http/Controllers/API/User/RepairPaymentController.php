<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Mail\EmailTicket;
use App\Models\AdminFeature;
use App\Models\PaymentRequest;
use App\Models\RepairPayment;
use App\Models\Tracking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\API\BaseController as BaseController;

class RepairPaymentController extends BaseController
{
    public function store(Request $request)
    {
        if($request->name) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|unique:users',
            ]);

            if ($validator->fails()) {
                return  response()->json(['errors'=>$validator->errors()], 422);
            }

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password =  Hash::make($request->password);

            if(auth()->user()) {
                $user->verify = 1;
            } else {
                $user->verify = 2;
            }

            $verify_token = base64_encode(date("mdY").rand(10,100000));
            $verify_token = urlencode($verify_token);
            $user->verify_token = $verify_token;

            $user->assignRole('user');

            $user->save();
        }

        $payment = new RepairPayment();
        $payment->serial_num = $request->serial_num;
        $payment->problem = $request->problem;
        $payment->bitmain_id = $request->bitmain_id;
        $payment->street = $request->street;
        $payment->city = $request->city;
        $payment->country = $request->country;
        $payment->postalcode = $request->postalcode;
        $payment->payment_method = $request->payment_method;

        if($request->user_id) {
            $payment->verify = 1;
        } else {
            $payment->verify = 2;
        }

        $payment->status = 1;

        if($request->user_id) {
            $payment->user_id = $request->user_id;
        }else {
            $payment->user_id = $user->id;
        }


        $requests = RepairPayment::get();
        $random_key = $requests->count() + 1;

        $payment->number = 'REP' . '-' . date("mdY") . str_pad($random_key, 2, "0", STR_PAD_LEFT);
        $payment->selected_lang = app()->getLocale();
        $payment->save();
        $paymentId = $payment->id;

//        if($request->user_id) {
//            $admin_users = User::role('admin')->where("verify", "=", "1")->get();
//            if($admin_users->count()) {
//                foreach ($admin_users as $adminkey => $adminvalue) {
//                    // Send to Admin
//                    $AdminFeature = AdminFeature::where("admin_id", "=", $adminvalue->id)->where("feature", "=", "receive_customer_reply_mail")->first();
//                    if(!empty($AdminFeature)) {
//                        $mailData = [
//                            'title' => trans('email.repair_publish_mail_to_admin_title'),
//                            'description' => str_replace('{user}',$request->name,trans('email.repair_publish_mail_to_admin_description')),
//                            'description' => trans('email.repair_publish_mail_to_admin_description'),
//                            'button' => trans('email.repair_publish_mail_to_admin_button'),
//                            'url' => 'http://euronetsupport.com/admin/repair/payment'
//                        ];
//                        Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
//                        Tracking::create(["email"=>$adminvalue->email,"button"=>json_encode($mailData)]);
//                    }
//                }
//            }
//
//            // Send to user
//            $mailData = [
//                'title' => trans('email.repair_publish_mail_to_user_title'),
//                'description' => trans('email.repair_publish_mail_to_user_description'),
//                'button' => trans('email.repair_publish_mail_to_user_button'),
//                'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$paymentId
//            ];
//
//            Mail::to($request->user_id)->send(new EmailTicket($mailData));
//            Tracking::create(["email"=>auth()->user()->email,"button"=>json_encode($mailData)]);
//        } else {
//            $mailData = [
//                'title' => trans('email.user_verify_mail_to_user_title'),
//                'description' => trans('email.user_verify_mail_to_user_description'),
//                'button' => trans('email.user_verify_mail_to_user_button'),
//                'url' => 'http://euronetsupport.com/login/'.$verify_token.'/'
//            ];
//
//            Mail::to($request->email)->send(new EmailTicket($mailData));
//            Tracking::create(["email"=>$request->email,"button"=>json_encode($mailData)]);
//        }

        $success['payment'] = $payment;
        return $this->sendResponse($success, 'successfully');
    }
    public function history(Request $request)
    {
        $requests = RepairPayment::orderBy("last_admin_reply_date", "DESC")->with('repairStatus')->where("user_id", "=", $request->user_id)->get();

        $success['payments'] = $requests;
        return $this->sendResponse($success, 'successfully');
    }
    public function detail(Request $request, $id)
    {
        $rPayment = RepairPayment::with("request")->with('reply')->with('repairStatus')->with('bitmain')->where("id", "=", $id)->first();
        $rPayment->last_admin_reply = 2;
        $rPayment->save();

        $success['payment'] = $rPayment;
        return $this->sendResponse($success, 'successfully');
    }

    public function pay(Request $request)
    {
        $payment = new PaymentRequest();
        $payment->amount = $request->amount;
        $payment->description = $request->description;
        $payment->repair_id = $request->repair_id;
        $payment->user_id = $request->user_id;
        $payment->status = $request->status;
        $payment->currency = $request->currency;
        $payment->save();
        $success['payment'] = $payment;
        return $this->sendResponse($success, 'successfully');
    }
}
