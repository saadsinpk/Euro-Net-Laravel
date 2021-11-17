<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use App\Models\Ticket;
use App\Models\RepairPayment;
use App\Models\RepairStatus;
use DataTables;
use Lang;

class UserController extends Controller
{
    //
    
    public function index() {
        $permissions = Permission::orderBy("created_at", "DESC")->get();
        $users = User::role('user')->where("verify", "=", "1")->orderBy("created_at", "DESC")->get();
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
                    $action .=  '<a href="users/view-ticket/'.$data->id.'">Tickets</a> | <a href="users/view-repair/'.$data->id.'">Repair</a>';
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

                        $action .= '<div class="menu-item px-3">
                                        <a href="'.url("/admin/users/view/$data->id").'" class="menu-link px-3">'.Lang::get('form.Edit').'</a>
                                    </div>';
                    }

                    if(auth()->user()->hasPermissionTo('delete')) {

                        $action .= '<div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-kt-table-filter="delete_row">'.Lang::get('form.Delete').'</a>
                                     </div>';
                    }

                    $action .= "</div>";
                }

                return $action;
            })

            ->rawColumns(['checkbox', 'group', 'action', 'created_at'])
            ->addIndexColumn()
            ->make(true);
        }
        
        return view("admin.user.index", compact("users", "permissions"));
    }

    public function store(Request $request) {

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

        return response()->json('200');
    }

    public function destroy ($id) {
        $user = User::find($id);
        $user->delete();
        $user->syncRoles('admin');

        if($user->avatar) {
            $path = public_path('uploads/avatar/'.$user->avatar.'');
    
            unlink($path);
        }

        return response()->json('200');
    }

    public function destroyRows(Request $request) {
        $users = User::whereIn("id", explode(",", $request->ids))->get();
        User::whereIn("id", explode(",", $request->ids))->delete();
        foreach ($users as $user) {
            $user->syncRoles('admin');
            if($user->avatar) {
                $path = public_path('uploads/avatar/'.$user->avatar.'');
        
                unlink($path);
            }
        }
        return response()->json('200');
    }

    public function view_ticket($id) {
        $tickets = Ticket::with("user")->with("category")->where("user_id", $id)->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->paginate(10);
        return view("admin.ticket.index", compact("tickets"));
    }

    public function view_repair($id) {
        $payments = RepairPayment::with('user', 'request')->where("user_id", $id)->where("verify", '1')->with('repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
        $repair_status = RepairStatus::all();

        return view("admin.repair_payment", compact('payments', 'repair_status'));
    }

    public function details($id) {
        $permissions = Permission::orderBy("created_at", "DESC")->get();
        $user = User::find($id);

        return view("admin.user.details", compact("user", "permissions"));
    }

    public function update(Request $request) {
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
            if($key == "new_password" || "old_password" || "confirmed_password") {
                if($request->old_password || $request->new_password) {
                    $request->validate([
                        'old_password'   => '|required',
                        'new_password'   =>  'required_with:confirmed_password|string|same:confirmed_password',
                        'confirmed_password'   =>  'required_with:new_password'
                    ]);
                    
                    if (Hash::check($request->old_password, $user->password)) { 
                        $user->fill([
                         'password' => Hash::make($request->new_password)
                         ])->save();
                     
                         return response()->json($request->new_password);
                     } else {
                         return abort(401);
                     }
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
            $user->save();
        }
    }
}
