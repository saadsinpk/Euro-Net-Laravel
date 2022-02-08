<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Mail\EmailTicket;
use App\Models\AdminLog;
use App\Models\BitMain;
use App\Models\RepairPayment;
use App\Models\Ticket;
use App\Models\Tracking;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource as UserResource;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;

class UserController extends BaseController
{
    public function admins()
    {
        $users = User::role('admin')->orderBy("created_at", "DESC")->get();
        return $this->sendResponse(UserResource::collection($users), 'Admins retrieved successfully.');
    }
    public function index()
    {
        $users = User::role('user')->orderBy("created_at", "DESC")->get();

        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($request->id);
        $users = User::where("id", "!=", $request->id)->get();
        foreach ($request->all() as $key => $value) {
            if($key == "email") {
                foreach ($users as $u) {
                    if($u->email == $value) {
                        $validator = Validator::make($request->all(), [
                            'email' => 'required|string|email|unique:users'
                        ]);

                        if ($validator->fails()) {
                            return  response()->json(['errors'=>$validator->errors()], 422);
                        }
                    }
                }
            }
            if($key == "new_password" || "confirmed_password") {
                if($request->new_password) {
                    $request->validate([
                        'new_password'   =>  'required_with:confirmed_password|string|same:confirmed_password',
                        'confirmed_password'   =>  'required_with:new_password'
                    ]);

                    $user->fill([
                        'password' => Hash::make($request->new_password)
                    ])->save();

                    return response()->json($request->new_password);
                }
            }
            if($key == "avatar") {
                $request->validate([
                    'avatar' => 'image|max:50000'
                ]);

                $file = $value;
                $fileName = time().'_'.$file->getClientOriginalName();
                $value->move(public_path('uploads/avatar'), $fileName);

                $value = time().'_'. $file->getClientOriginalName();
            }
if ($request->phone) {
    $user['phone'] = $request->phone;
}
            $user[$key] = $value;

            $user->save();
            $success['name'] =  $user->name;
            $success['phone'] =  $user->phone;
            return $this->sendResponse($success, 'User Updated successfully.');
        }
    }

    public function bitmain()
    {
        $bitmain = BitMain::all();
        $success['datas'] = $bitmain;
        return $this->sendResponse($success, 'successfully');

    }

    public function verify($id, Request $request){
            $update_user = User::where("id", $id)->first();
            $message_to_display = 'fail';
            if(!empty($update_user)) {
                $update_user->verify = 1;

                $message = 'Update User to verify "'.$update_user->name.' ('.$update_user->email.')" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
//                AdminLog::create(["admin_id"=>$request->admin_id,"message"=>$message,"status"=>"warning"]);

                $update_user->save();

                $ticket = Ticket::where("user_id", "=", $update_user->id)->first();
                if(!empty($ticket)) {
                    $ticket->show_ticket = 1;
                    $ticket->save();
//
//                    $ticket_id = $ticket->id;
//                    $ticket_number = $ticket->number;
//
//                    $admin_users = User::role('admin')->where("verify", "=", "1")->get();
//                    if($admin_users->count()) {
//                        foreach ($admin_users as $adminkey => $adminvalue) {
//                            // Send to Admin
//                            $mailData = [
//                                'title' => trans('email.ticket_publish_mail_to_admin_title'),
//                                'description' => str_replace('{user}',$update_user->name,trans('email.ticket_publish_mail_to_admin_description')),
//                                'button' => trans('email.ticket_publish_mail_to_admin_button'),
//                                'url' => 'https://euronetsupport.com/admin/ticket/view/'.$ticket_id
//                            ];
//                            Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
//                            Tracking::create(["email"=>$adminvalue->email,"button"=>json_encode($mailData)]);
//                        }
//                    }
//
//                    // Send to user
//                    $mailData = [
//                        'title' => trans('email.ticket_publish_mail_to_user_title'),
//                        'description' => str_replace(array('{user}', '{ticket}'),array($update_user->name, $ticket_number),trans('email.ticket_publish_mail_to_user_description')),
//                        'button' => trans('email.ticket_publish_mail_to_user_button'),
//                        'url' => 'https://euronetsupport.com/user/ticket-view/'.$ticket_id
//                    ];
//
//                    Mail::to($update_user->email)->send(new EmailTicket($mailData));
//                    Tracking::create(["email"=>$update_user->email,"button"=>json_encode($mailData)]);
                }

                $ticket = RepairPayment::where("user_id", "=", $update_user->id)->first();
                if(!empty($ticket)) {
                    $ticket->verify = 1;
                    $ticket->save();

//                    $ticket_id = $ticket->id;
//                    $ticket_number = $ticket->number;
//
//                    $admin_users = User::role('admin')->where("verify", "=", "1")->get();
//                    if($admin_users->count()) {
//                        foreach ($admin_users as $adminkey => $adminvalue) {
//                            // Send to Admin
//                            $mailData = [
//                                'title' => trans('email.repair_publish_mail_to_admin_title'),
//                                'description' => trans('email.repair_publish_mail_to_admin_description'),
//                                'button' => trans('email.ticket_publish_mail_to_admin_button'),
//                                'url' => 'http://euronetsupport.com/admin/repair/payment'
//                            ];
//                            Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
//                            Tracking::create(["email"=>$adminvalue->email,"button"=>json_encode($mailData)]);
//                        }
//                    }
//
//                    // Send to user
//                    $mailData = [
//                        'title' => trans('email.ticket_publish_mail_to_user_title'),
//                        'description' => str_replace(array('{user}', '{ticket}'),array($update_user->name, $ticket_number),trans('email.ticket_publish_mail_to_user_description')),
//                        'button' => trans('email.ticket_publish_mail_to_user_button'),
//                        'url' => 'https://euronetsupport.com/user/repair_payment/'.$ticket_id
//                    ];
//
//                    Mail::to($update_user->email)->send(new EmailTicket($mailData));
//                    Tracking::create(["email"=>$update_user->email,"button"=>json_encode($mailData)]);
                }

                $message_to_display = 'pass';
            }

            $permissions = Permission::orderBy("created_at", "DESC")->get();
            $users = User::role('user')->orderBy("created_at", "DESC")->get();

        $success['data'] = $message;
        return $this->sendResponse($success, 'successfully');

    }
}
