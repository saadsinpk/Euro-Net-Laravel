<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepairPayment;
use DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RepairPaymentController extends Controller
{
    //
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

        if(auth()->user()) {
            $payment->user_id = auth()->user()->id;
        }else {
            $payment->user_id = $user->id;
        }


        $requests = RepairPayment::get();
        $random_key = $requests->count() + 1;

        $payment->number = 'REP' . '-' . date("mdY") . str_pad($random_key, 2, "0", STR_PAD_LEFT);
        $payment->save();

        if(auth()->user()) {
            $admin_users = User::role('admin')->where("verify", "=", "1")->get();
            if($admin_users->count()) {
                foreach ($admin_users as $adminkey => $adminvalue) {
                    // Send to Admin
                    $mailData = [
                        'title' => trans('email.ticket_publish_mail_to_admin_title'),
                        'description' => trans('email.ticket_publish_mail_to_admin_description'),
                        'button' => trans('email.ticket_publish_mail_to_admin_button'),
                        'url' => 'https://euronetsupport.com/admin/ticket/view/'.$ticket_id
                    ];
                    Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
                }
            }

            // Send to user
            $mailData = [
                'title' => trans('email.ticket_publish_mail_to_user_title'),
                'description' => trans('email.ticket_publish_mail_to_user_description'),
                'button' => trans('email.ticket_publish_mail_to_user_button'),
                'url' => 'https://euronetsupport.com/user/ticket-view/'.$ticket_id
            ];

            Mail::to(auth()->user()->email)->send(new EmailTicket($mailData));
        } else {
            $mailData = [
                'title' => trans('email.user_verify_mail_to_user_title'),
                'description' => trans('email.user_verify_mail_to_user_description'),
                'button' => trans('email.user_verify_mail_to_user_button'),
                'url' => 'http://euronetsupport.com/login/'.$verify_token.'/'
            ];

            Mail::to($request->email)->send(new EmailTicket($mailData));
        }

        return response()->json($payment->id);
    }

    public function history() 
    {
        $requests = RepairPayment::orderBy("created_at", "DESC")->get();

        if (request()->ajax()) {
            return DataTables::of($requests)
            ->addColumn('created_at', function ($data) {
                $date =  $data->created_at->format("d M Y, g:i A");
                return $date;
            })
            ->addColumn('action', function ($data) {
                $action = '<a href="'.url("/user/repair_payment/view/$data->id").'" class="btn btn-light btn-sm">View</a>';

                return $action;
            })

            ->rawColumns(['action', 'created_at'])
            ->addIndexColumn()
            ->make(true);
        }
    }

    public function detail($id)
    {
        $rPayment = RepairPayment::with("request")->where("id", "=", $id)->first();

        return view("user.rPayment_detail", compact("rPayment"));
    }


}
