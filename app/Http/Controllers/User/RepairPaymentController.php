<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepairPayment;
use DataTables;
use App\Models\User;
use App\Models\RepairReply;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTicket;
use App\Models\AdminFeature;
use App\Models\Tracking;

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
        $payment->street = $request->street;
        $payment->city = $request->city;
        $payment->country = $request->country;
        $payment->postalcode = $request->postalcode;
        $payment->payment_method = $request->payment_method;

        if(auth()->user()) {
            $payment->verify = 1;
        } else {
            $payment->verify = 2;
        }
        
        $payment->status = 1;

        if(auth()->user()) {
            $payment->user_id = auth()->user()->id;
        }else {
            $payment->user_id = $user->id;
        }


        $requests = RepairPayment::get();
        $random_key = $requests->count() + 1;

        $payment->number = 'REP' . '-' . date("mdY") . str_pad($random_key, 2, "0", STR_PAD_LEFT);
        $payment->selected_lang = app()->getLocale();
        $payment->save();
        $paymentId = $payment->id;

        if(auth()->user()) {
            $admin_users = User::role('admin')->where("verify", "=", "1")->get();
            if($admin_users->count()) {
                foreach ($admin_users as $adminkey => $adminvalue) {
                    // Send to Admin
                    $AdminFeature = AdminFeature::where("admin_id", "=", $adminvalue->id)->where("feature", "=", "receive_customer_reply_mail")->first();
                    if(!empty($AdminFeature)) {
                        $mailData = [
                            'title' => trans('email.repair_publish_mail_to_admin_title'),
                            'description' => str_replace('{user}',$request->name,trans('email.repair_publish_mail_to_admin_description')),
                            'description' => trans('email.repair_publish_mail_to_admin_description'),
                            'button' => trans('email.repair_publish_mail_to_admin_button'),
                            'url' => 'http://euronetsupport.com/admin/repair/payment'
                        ];
                        Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
                        Tracking::create(["email"=>$adminvalue->email,"button"=>json_encode($mailData)]);
                    }
                }
            }

            // Send to user
            $mailData = [
                'title' => trans('email.repair_publish_mail_to_user_title'),
                'description' => trans('email.repair_publish_mail_to_user_description'),
                'button' => trans('email.repair_publish_mail_to_user_button'),
                'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$paymentId
            ];

            Mail::to(auth()->user()->email)->send(new EmailTicket($mailData));
                        Tracking::create(["email"=>auth()->user()->email,"button"=>json_encode($mailData)]);
        } else {
            $mailData = [
                'title' => trans('email.user_verify_mail_to_user_title'),
                'description' => trans('email.user_verify_mail_to_user_description'),
                'button' => trans('email.user_verify_mail_to_user_button'),
                'url' => 'http://euronetsupport.com/login/'.$verify_token.'/'
            ];

            Mail::to($request->email)->send(new EmailTicket($mailData));
                        Tracking::create(["email"=>$request->email,"button"=>json_encode($mailData)]);
        }

        return response()->json($payment->id);
    }

    public function shipping_history()
    {
        $requests = RepairPayment::orderBy("last_admin_reply_date", "DESC")->with('repairStatus')->where("user_id", "=", auth()->user()->id)->where("status","=","7")->orWhere(function($query) {
                $query->where('user_id', '=', auth()->user()->id)
                      ->where('status', '=', 2);
            })->get();
        if (request()->ajax()) {
            return DataTables::of($requests)
            ->addColumn('action', function ($data) {
                if($data->status == '2') {
                    $action = '<a href="'.url("/user/repair_payment/view/$data->id").'" class="btn btn-light btn-sm">Add shipping detail</a>';
                } elseif($data->status == '7') {
                    $action = '<a href="'.url("/user/repair_payment/view/$data->id").'" class="btn btn-light btn-sm">View shipping detail</a>';
                }

                return $action;
            })
            ->addColumn('tracking_number', function ($data) {
                if($data->status == '2') {
                    $tracking_number = $data->tracking_number;
                } elseif($data->status == '7') {
                    $tracking_number = $data->return_tracking_number;
                }
                if(empty($tracking_number)) {
                    $tracking_number = '-';
                }
                return $tracking_number;
            })
            ->addColumn('shipping_company', function ($data) {
                if($data->status == '2') {
                    $shipping_company = $data->shipping_company;
                } elseif($data->status == '7') {
                    $shipping_company = $data->return_shipping_company;
                }
                if(empty($shipping_company)) {
                    $shipping_company = '-';
                }
                return $shipping_company;
            })
            ->addColumn('label', function ($data) {
                $label = '<a href="'.url('label/download/'.$data->number).'"  target="_blank">Download Label</a>';
                return $label;
            })
            ->rawColumns(['action', 'tracking_number', 'shipping_company', 'label', 'pdf'])
            ->addIndexColumn()
            ->make(true);
        }
        return '';
    }
    public function history() 
    {
        $requests = RepairPayment::orderBy("last_admin_reply_date", "DESC")->with('repairStatus')->where("user_id", "=", auth()->user()->id)->get();
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
            ->addColumn('status', function ($data) {
                $status = '<span class="badge text-white" style="background: '.$data->repairStatus->color.';">'.$data->repairStatus->option.'</span>';

                return $status;
            })
            ->rawColumns(['action', 'status', 'created_at'])
            ->addIndexColumn()
            ->make(true);
        }
    }
    public function download_pdf(Request $request, $id)
    {
        echo 'test';
        exit();
    }

    public function detail(Request $request, $id)
    {
        if(isset($_POST['update_shipping'])) {
            RepairPayment::where("id", "=", $id)->update(["shipping_company"=>$request->shipping_company,"tracking_number"=>$request->tracking_number,"ship_attach"=>$request->file_name]);
        }
        if(!auth()->user()) {
            return redirect('/login');
        }
        $rPayment = RepairPayment::with("request")->with('reply')->with('repairStatus')->with('bitmain')->where("id", "=", $id)->first();
        $rPayment->last_admin_reply = 2;
        $rPayment->save();
        return view("user.rPayment__detail", compact("rPayment"));
    }

    public function detail_pay($id, $payid)
    {
        $rPayment = RepairPayment::with("request")->with('reply')->with('repairStatus')->with('bitmain')->where("id", "=", $id)->first();

        return view("user.rPayment_pay_detail", compact("rPayment", "payid"));
    }

    public function reply(Request $request)
    {
        $repair_reply = new RepairReply;
        
        $rPayment = RepairPayment::where("id", "=", $request->repair_id)->first();

        $rPayment->ischecked = 0;

        $repair_id = $request->repair_id; 

        $admin_users = User::role('admin')->where("verify", "=", "1")->get();
        if($admin_users->count()) {
            foreach ($admin_users as $adminkey => $adminvalue) {
                $AdminFeature = AdminFeature::where("admin_id", "=", $adminvalue->id)->where("feature", "=", "receive_customer_reply_mail")->first();
                if(!empty($AdminFeature)) {

                    // Send to Admin
                    $mailData = [
                        'title' => trans('email.user_send_reply_repair_to_admin_title'),
                        'description' => $request->description,
                        'button' => trans('email.user_send_reply_repair_to_admin_button_label'),
                        'url' => 'https://euronetsupport.com/admin/reapir/view/'.$repair_id
                    ];
                    Mail::to($adminvalue->email)->send(new EmailTicket($mailData)); 
                        Tracking::create(["email"=>$adminvalue->email,"button"=>json_encode($mailData)]);
                }
            }
        }

        foreach($request->except('_token') as $key => $value)
        {
            if($key == "file_name") {
                $value = implode(",", $value);
            } 
            $repair_reply[$key] = $value;
        }
        
        $repair_reply->save();
        $rPayment->selected_lang = app()->getLocale();
        $rPayment->save();
        
        return response()->json(200);
    }
}
