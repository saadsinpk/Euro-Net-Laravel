<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Ticket_reply;
use App\Models\Category;
use App\Models\PaymentRequest;
use DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\BitMain;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\RepairPayment;
use App\Mail\EmailTicket;

class TicketController extends Controller
{
    //

    public function index()
    {
        $categories = Category::all();
        $bitmain = BitMain::all();
        return view("user.ticket", compact("categories", 'bitmain'));
    }

    public function verifyuser($id) {
            $user = User::role('user')->where("verify", "!=", "1")->where("verify_token", "=", urlencode($id))->first();

            if(!empty($user)) {
                $user->verify = 1;
                $user->save();
                
                $ticket = Ticket::where("user_id", "=", $user->id)->first();
                if(!empty($ticket)) {
                    $ticket->show_ticket = 1;
                    $ticket->save();

                    $ticket_id = $ticket->id;
                    $ticket_number = $ticket->number;

                    $admin_users = User::role('admin')->where("verify", "=", "1")->get();
                    if($admin_users->count()) {
                        foreach ($admin_users as $adminkey => $adminvalue) {
                            // Send to Admin
                            $mailData = [
                                'title' => trans('email.ticket_publish_mail_to_admin_title'),
                                'description' => str_replace('{user}',$user->name,trans('email.ticket_publish_mail_to_admin_description')),
                                'button' => trans('email.ticket_publish_mail_to_admin_button'),
                                'url' => 'https://euronetsupport.com/admin/ticket/view/'.$ticket_id
                            ];
                            Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
                        }
                    }

                    // Send to user
                    $mailData = [
                        'title' => trans('email.ticket_publish_mail_to_user_title'),
                        'description' => str_replace(array('{user}', '{ticket}'),array($user->name, $ticket_number),trans('email.ticket_publish_mail_to_user_description')),
                        'button' => trans('email.ticket_publish_mail_to_user_button'),
                        'url' => 'https://euronetsupport.com/user/ticket-view/'.$ticket_id
                    ];

                    Mail::to($user->email)->send(new EmailTicket($mailData));
                }

                $ticket = RepairPayment::where("user_id", "=", $user->id)->first();
                if(!empty($ticket)) {
                    $ticket->verify = 1;
                    $ticket->save();

                    $ticket_id = $ticket->id;
                    $ticket_number = $ticket->number;

                    $admin_users = User::role('admin')->where("verify", "=", "1")->get();
                    if($admin_users->count()) {
                        foreach ($admin_users as $adminkey => $adminvalue) {
                            // Send to Admin
                            $mailData = [
                                'title' => trans('email.repair_publish_mail_to_admin_title'),
                                'description' => trans('email.repair_publish_mail_to_admin_description'),
                                'button' => trans('email.ticket_publish_mail_to_admin_button'),
                                'url' => 'http://euronetsupport.com/admin/repair/payment'
                            ];
                            Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
                        }
                    }

                    // Send to user
                    $mailData = [
                        'title' => trans('email.ticket_publish_mail_to_user_title'),
                        'description' => str_replace(array('{user}', '{ticket}'),array($user->name, $ticket_number),trans('email.ticket_publish_mail_to_user_description')),
                        'button' => trans('email.ticket_publish_mail_to_user_button'),
                        'url' => 'https://euronetsupport.com/user/repair_payment/'.$ticket_id
                    ];

                    Mail::to($user->email)->send(new EmailTicket($mailData));
                }

                $message_to_display = 'pass';
            } else {
                $message_to_display = 'fail';
            }
        return view("auth.login", compact("message_to_display"));
    }

    public function store(Request $request)
    {   
        $ticket = new Ticket;
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

        $ticket->subject = $request->subject;
        $ticket->category_id = $request->category_id;
        $ticket->description = $request->description;

        if(auth()->user()) {
            $ticket->user_id = auth()->user()->id;
            $ticket->user_email = auth()->user()->email;
        }else {
            $ticket->user_id = $user->id;
            $ticket->user_email = $user->email;
        }
        $ticket->status = 1;

        if(auth()->user()) {
            $ticket->show_ticket = 1;
        } else {
            $ticket->show_ticket = 2;
        }
        $ticket->flag = 1;
        $tickets = Ticket::get();
        $random_key = $tickets->count() + 1;
        
        $category = Category::find($request->category_id);

        if($request->category_id == 5) {
            $category->name = "EUR";
        }

        $ticket->number = strtoupper(substr($category->name, 0, 3)) . '-' . date("mdY") . str_pad($random_key, 2, "0", STR_PAD_LEFT);

        if($request->file_name) {
            $ticket->file_name = implode(",", $request->file_name); 
        } 

        $ticket->save();
        $ticket_id = $ticket->id;
        $ticket_number = $ticket->number;

        if(auth()->user()) {
            $admin_users = User::role('admin')->where("verify", "=", "1")->get();
            if($admin_users->count()) {
                foreach ($admin_users as $adminkey => $adminvalue) {
                    // Send to Admin
                    $mailData = [
                        'title' => trans('email.ticket_publish_mail_to_admin_title'),
                        'description' => str_replace('{user}',auth()->user()->name,trans('email.ticket_publish_mail_to_admin_description')),
                        'button' => trans('email.ticket_publish_mail_to_admin_button'),
                        'url' => 'https://euronetsupport.com/admin/ticket/view/'.$ticket_id
                    ];
                    Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
                }
            }

            // Send to user
            $mailData = [
                'title' => trans('email.ticket_publish_mail_to_user_title'),
                'description' => str_replace(array('{user}', '{ticket}'),array(auth()->user()->name, $ticket_number),trans('email.ticket_publish_mail_to_user_description')),
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
        


        return response()->json($ticket->id);
    }

    public function tickethistory() 
    {
        if(auth()->user()) {
            $tickets = Ticket::orderBy("created_at", "DESC")->with("ticket_status")->where("user_id", "=", auth()->user()->id)->get();
    
            if (request()->ajax()) {
                return DataTables::of($tickets)
                ->addColumn('status', function($data){
                    return $data = '<div class="badge badge-light-danger">'.$data->ticket_status->option.'</div>';
                })
                ->addColumn('category_name', function($data){
                    return $data->category->name;
                })
                ->addColumn('created_at', function ($data) {
                    $date =  $data->created_at->format("d M Y, g:i A");
                    return $date;
                })
                ->addColumn('number', function($data){
                    return $data->number;
                })
                ->addColumn('action', function ($data) {
                    $action = '<a href="'.url("/user/ticket-view/$data->id").'" class="btn btn-light btn-sm">View</a>';
    
                    return $action;
                })
    
                ->rawColumns(['created_at', 'status', 'action'])
                ->addIndexColumn()
                ->make(true);
            }   
        }
    }


    public function ticketDetail($id) {
        if(isset(auth()->user()->id)) {
            $ticket = Ticket::with("category")->with("reply")->where("id", "=", $id)->where("user_id","=", auth()->user()->id)->first();
            if($ticket) {
                return view("user.ticket_detail", compact("ticket"));
            } else {
                return abort('404');
            }
        }
    }


    public function sendAnswer(Request $request)
    {
        $ticket_reply = new Ticket_reply;
        
        $ticket = Ticket::where("id", "=", $request->ticket_id)->first();
        $ticket->ischecked = 0;

        $ticket_id = $request->ticket_id; 
        
        $admin_users = User::role('admin')->where("verify", "=", "1")->get();
        if($admin_users->count()) {
            foreach ($admin_users as $adminkey => $adminvalue) {
                // Send to Admin
                $mailData = [
                    'title' => trans('email.user_send_reply_to_admin_title'),
                    'description' => $request->description,
                    'button' => trans('email.user_send_reply_to_admin_button_label'),
                    'url' => 'https://euronetsupport.com/admin/ticket/view/'.$ticket_id
                ];
                Mail::to($adminvalue->email)->send(new EmailTicket($mailData)); 
            }
        }

        

        foreach($request->except('_token') as $key => $value)
        {
            if($key == "file_name") {
                $value = implode(",", $value);
            } 
            $ticket_reply[$key] = $value;
        }
        
        $ticket_reply->save();
        $ticket->status = 2;
        $ticket->flag = 1;
        
        $ticket->save();
   
        return response()->json(200);
    }
}
