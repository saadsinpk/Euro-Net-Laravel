<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use App\Models\Ticket;
use App\Models\AdminLog;
use App\Models\RepairPayment;
use App\Models\RepairStatus;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTicket;
use DataTables;
use Lang;
use App\Models\Tracking;

class UserController extends Controller
{
    //
    
    public function index() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_user'])) {
            $permissions = Permission::orderBy("created_at", "DESC")->get();
            $users = User::role('user')->orderBy("created_at", "DESC")->get();
            if (request()->ajax()) {
                return DataTables::of($users)

                ->addColumn('checkbox', function ($data) {
                    $checkbox = '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" value="1" />
                                    <input type="hidden" value="'.$data->id.'">
                                </div>';
                    return $checkbox;
                })
                ->addColumn('created_at', function ($data) {
                    $date =  $data->created_at->format("d M Y, g:i A");
                    return $date;
                })
                ->addColumn('action', function ($data) {
                    $admin_access = $this->get_current_admin_access();
                    $action = "";
                    if(auth()->user()->hasAnyPermission(['edit', 'delete'])) {
                        if(isset($admin_access['verify_user'])) {
                            if($data->verify == 1) {
                                $action .= '<a href="#">Already Verify</a> | ';
                            } else {
                                $action .= '<a href="'.url('/admin/users/verify/').'/'.$data->id.'">Verify now</a> | ';
                            }
                        }
                        if(isset($admin_access['read_ticket'])) {
                            $action .=  '<a href="'.url('/admin/users/view-ticket/').'/'.$data->id.'">Tickets</a>'; 
                        }
                        if(isset($admin_access['read_repair']) AND isset($admin_access['read_ticket'])) {
                            $action .= ' | ';
                        }
                        if(isset($admin_access['read_repair'])) {
                            $action .= '<a href="'.url('/admin/users/view-repair/').'/'.$data->id.'">Repair</a>';
                        }

                        $action .= 
                            '<a href="#" class="btn btn-sm btn-light btn-active-light-primary btn-action" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'.Lang::get('form.Actions').'
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>
                            </a>';
                    }
                        
                    if(auth()->user()->hasPermissionTo('edit') || auth()->user()->hasPermissionTo('delete') || auth()->user()->hasPermissionTo('give permission')) {
                        $action .=  
                        '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">';
                        
                        if(auth()->user()->hasPermissionTo('edit')) {
                            if(isset($admin_access['edit_user'])) {
                                $action .= '<div class="menu-item px-3">
                                            <a href="'.url("/admin/users/view/").'/'.$data->id.'" class="menu-link px-3">'.Lang::get('form.Edit').'</a>
                                        </div>';
                            }
                        }

                        if(auth()->user()->hasPermissionTo('delete')) {
                            if(isset($admin_access['delete_user'])) {
                                $action .= '<div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-table-filter="delete_row">'.Lang::get('form.Delete').'</a>
                                             </div>';
                            }
                        }

                        $action .= "</div>";
                    }

                    return $action;
                })

                ->rawColumns(['checkbox', 'group', 'action', 'created_at'])
                ->addIndexColumn()
                ->make(true);
            }
            
            return view("admin.user.index", compact("admin_access", "users", "permissions"));
        } else{
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request) {
        $admin_access = $this->get_current_admin_access();
        if($admin_access['add_user']) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|unique:users',
            ]);

            if ($validator->fails()) {    
                return  response()->json(['errors'=>$validator->errors()], 422);
            }

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->verify = 1;
            $user->password =  Hash::make($request->password);

            $user->assignRole('user');

            $user->save();

            $message = 'Create User "'.$user->name.' ('.$user->email.')" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"success"]);

            return response()->json('200');
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }

    public function destroy ($id) {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['delete_user'])) {
            $user = User::find($id);
            $message = 'Delete User "'.$user->name.' ('.$user->email.')" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

            $user->syncRoles('admin');

            if($user->avatar) {
                $path = public_path('uploads/avatar/'.$user->avatar.'');
        
                unlink($path);
            }
            $user->delete();

            return response()->json('200');
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }

    public function destroyRows(Request $request) {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['delete_user'])) {
            $users = User::whereIn("id", explode(",", $request->ids))->get();
            User::whereIn("id", explode(",", $request->ids))->delete();
            foreach ($users as $user) {
                $message = 'Delete User "'.$user->name.' ('.$user->email.')" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
                AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

                $user->syncRoles('admin');
                if($user->avatar) {
                    $path = public_path('uploads/avatar/'.$user->avatar.'');
            
                    unlink($path);
                }
            }
            return response()->json('200');
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }

    public function view_ticket($id) {
        $admin_access = $this->get_current_admin_access();
        if($admin_access['read_ticket']) {
            $tickets = Ticket::with("user")->with("category")->where("user_id", $id)->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            return view("admin.ticket.index", compact("admin_access", "tickets"));
        } else {
            return redirect()->route('admin_user');
        }
    }

    public function view_repair($id) {
        $admin_access = $this->get_current_admin_access();
        if($admin_access['read_repair']) {
            $payments = RepairPayment::with('user', 'request', 'repairStatus')->where("user_id", $id)->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            return view("admin.repair_payment", compact("admin_access", 'payments', 'repair_status'));
        } else {
            return redirect()->route('admin_user');
        }
    }

    public function details($id) {
        $admin_access = $this->get_current_admin_access();
        if($admin_access['edit_user']) {
            $admin_access = $this->get_current_admin_access();

            $permissions = Permission::orderBy("created_at", "DESC")->get();
            $user = User::find($id);

            return view("admin.user.details", compact("admin_access", "user", "permissions"));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function update(Request $request) {
        $admin_access = $this->get_current_admin_access();
        if($admin_access['edit_user']) {
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

                $user[$key] = $value;
                $message = 'Update User "'.$user->name.' ('.$user->email.')" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
                AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"warning"]);
                $user->save();
            }
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }
    public function verify($id){
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['verify_user'])) {
            $update_user = User::where("id", $id)->first();

            $message_to_display = 'fail';
            if(!empty($update_user)) {
                $update_user->verify = 1;

                $message = 'Update User to verify "'.$update_user->name.' ('.$update_user->email.')" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
                AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"warning"]);

                $update_user->save();
                
                $ticket = Ticket::where("user_id", "=", $update_user->id)->first();
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
                                'description' => str_replace('{user}',$update_user->name,trans('email.ticket_publish_mail_to_admin_description')),
                                'button' => trans('email.ticket_publish_mail_to_admin_button'),
                                'url' => 'https://euronetsupport.com/admin/ticket/view/'.$ticket_id
                            ];
                            Mail::to($adminvalue->email)->send(new EmailTicket($mailData));
                            Tracking::create(["email"=>$adminvalue->email,"button"=>json_encode($mailData)]);
                        }
                    }

                    // Send to user
                    $mailData = [
                        'title' => trans('email.ticket_publish_mail_to_user_title'),
                        'description' => str_replace(array('{user}', '{ticket}'),array($update_user->name, $ticket_number),trans('email.ticket_publish_mail_to_user_description')),
                        'button' => trans('email.ticket_publish_mail_to_user_button'),
                        'url' => 'https://euronetsupport.com/user/ticket-view/'.$ticket_id
                    ];

                    Mail::to($update_user->email)->send(new EmailTicket($mailData));
                            Tracking::create(["email"=>$update_user->email,"button"=>json_encode($mailData)]);
                }

                $ticket = RepairPayment::where("user_id", "=", $update_user->id)->first();
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
                            Tracking::create(["email"=>$adminvalue->email,"button"=>json_encode($mailData)]);
                        }
                    }

                    // Send to user
                    $mailData = [
                        'title' => trans('email.ticket_publish_mail_to_user_title'),
                        'description' => str_replace(array('{user}', '{ticket}'),array($update_user->name, $ticket_number),trans('email.ticket_publish_mail_to_user_description')),
                        'button' => trans('email.ticket_publish_mail_to_user_button'),
                        'url' => 'https://euronetsupport.com/user/repair_payment/'.$ticket_id
                    ];

                    Mail::to($update_user->email)->send(new EmailTicket($mailData));
                            Tracking::create(["email"=>$update_user->email,"button"=>json_encode($mailData)]);
                }

                $message_to_display = 'pass';
            }

            $permissions = Permission::orderBy("created_at", "DESC")->get();
            $users = User::role('user')->orderBy("created_at", "DESC")->get();
            if (request()->ajax()) {
                return DataTables::of($users)

                ->addColumn('checkbox', function ($data) {
                    $checkbox = '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" value="1" />
                                    <input type="hidden" value="'.$data->id.'">
                                </div>';
                    return $checkbox;
                })
                ->addColumn('created_at', function ($data) {
                    $date =  $data->created_at->format("d M Y, g:i A");
                    return $date;
                })
                ->addColumn('action', function ($data) {
                    $action = "";
                    if(auth()->user()->hasAnyPermission(['edit', 'delete'])) {
                        if(isset($admin_access['verify_user'])) {
                            if($data->verify == 1) {
                                $action .= '<a href="#">Already Verify</a> | ';
                            } else {
                                $action .= '<a href="'.url('/admin/users/verify/').'/'.$data->id.'">Verify now</a> | ';
                            }
                        }
                        if(isset($admin_access['read_ticket'])) {
                            $action .=  '<a href="'.url('/admin/users/view-ticket/').'/'.$data->id.'">Tickets</a>'; 
                        }
                        if(isset($admin_access['read_repair']) AND isset($admin_access['read_ticket'])) {
                            $action .= ' | ';
                        }
                        if(isset($admin_access['read_repair'])) {
                            $action .= '<a href="'.url('/admin/users/view-repair/').'/'.$data->id.'">Repair</a>';
                        }
                        $action .= 
                            '<a href="#" class="btn btn-sm btn-light btn-active-light-primary btn-action" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'.Lang::get('form.Actions').'
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                    </svg>
                                </span>
                            </a>';
                    }
                        
                    if(auth()->user()->hasPermissionTo('edit') || auth()->user()->hasPermissionTo('delete') || auth()->user()->hasPermissionTo('give permission')) {
                        $action .=  
                        '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">';
                        
                        if(auth()->user()->hasPermissionTo('edit')) {

                            if(isset($admin_access['edit_user'])) {
                                $action .= '<div class="menu-item px-3">
                                            <a href="'.url("/admin/users/view/").'/'.$data->id.'" class="menu-link px-3">'.Lang::get('form.Edit').'</a>
                                        </div>';
                            }
                        }

                        if(auth()->user()->hasPermissionTo('delete')) {
                            if(isset($admin_access['delete_user'])) {
                                $action .= '<div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-table-filter="delete_row">'.Lang::get('form.Delete').'</a>
                                             </div>';
                            }
                        }
                        $action .= "</div>";
                    }

                    return $action;
                })

                ->rawColumns(['checkbox', 'group', 'action', 'created_at'])
                ->addIndexColumn()
                ->make(true);
            }
            
            return view("admin.user.index", compact("admin_access", "users", "permissions", "message_to_display"));
        } else {
            return redirect()->route('admin_user');
        }
    }
}
