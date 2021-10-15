<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Config;
use DataTables;
use Lang;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:publish|edit|delete|', ['only' => ['index','details', 'update', 'store', 'destroy', 'destroyRows']]);
        $this->middleware('permission:publish', ['only' => ['store']]);
        $this->middleware('permission:edit', ['only' => ['update', ]]);
        $this->middleware('permission:delete', ['only' => ['destroy', 'destroyRows']]);
    }
    //

    public function index() {
        $permissions = Permission::orderBy("created_at", "DESC")->get();
        $users = User::role('admin')->orderBy("created_at", "DESC")->where("id", "!=", auth()->user()->id)->get();

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
                                        <a href="'.url("/admin/admins/view/$data->id").'" class="menu-link px-3">'.Lang::get('form.Edit').'</a>
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

            ->rawColumns(['checkbox', 'action', 'created_at'])
            ->addIndexColumn()
            ->make(true);
        }
        
        return view("admin.index", compact("users", "permissions"));
    }

    public function permissionList($id) {
        $permissions = Permission::orderBy("created_at", "DESC")->get();

        $user = User::find($id);
        $adminPername = "";
        foreach ($permissions as $per) {
            if($user->hasPermissionTo($per->name)) {
                $adminPername .= "," . $per->id;
            }
        }
        if (request()->ajax()) {
            return DataTables::of(Permission::select('*')->whereIn("id", explode(",", substr($adminPername, 1)) )->get())
            ->addColumn('action', function ($data){
                $action = 
                '<button class="btn btn-icon btn-active-light-primary w-30px h-30px" id="'.$data->id.'" data-kt-table-filter="delete_row">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                        </svg>
                    </span>
                </button>';
                return $action;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        // dd(substr($adminPername, 1));
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
        $user->password =  Hash::make($request->password);

        $user->assignRole('admin');

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

    public function details($id) {
        $permissions = Permission::orderBy("created_at", "DESC")->get();
        $user = User::find($id);

        return view("admin.details", compact("user", "permissions"));
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

    public function permission(Request $request) {
       $user = User::find($request->id);
       if($user->hasPermissionTo($request->permission_name)) {
            return abort(422);
       }else {
           $user->givePermissionTo($request->permission_name);
           return response()->json("200");
       }
    }

    public function RevokePermission(Request $request) {
        $user = User::find($request->user_id);
        $permission = Permission::find($request->per_id);
        $user->revokePermissionTo($permission->name);
        return response()->json(200);
    }

}
