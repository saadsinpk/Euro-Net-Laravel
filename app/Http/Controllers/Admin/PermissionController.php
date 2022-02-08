<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use App\Models\AdminLog;

use Illuminate\Support\Facades\Validator;
use Artisan;

class PermissionController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:publish|edit|delete|', ['only' => ['index','details', 'update', 'store', 'destroy', 'destroyRows']]);
        $this->middleware('permission:publish', ['only' => ['store']]);
        $this->middleware('permission:edit', ['only' => ['update', ]]);
        $this->middleware('permission:delete', ['only' => ['destroy', 'destroyRows']]);
    }
    //

    public function index() 
    {
        $permissions = Permission::orderBy("created_at", "DESC")->get();
        $users = User::all();

        return view("admin.permissions.index", compact("permissions", "users"));
    }

    public function store (Request $request)
    {
        Artisan::call('cache:clear');
        $users = User::all();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:permissions',
        ]);

        if ($validator->fails()) {    
            return  response()->json(['error'=>$validator->errors()], 422);
        }

      Permission::create(['name' => $request->name]);


        foreach ($users as $user) {
            if($user->hasRole("admin")) {
                $user->givePermissionTo($request->name);
            }
        }

        return response()->json("200");
    }

    public function destroy ($id) {
        Artisan::call('cache:clear');
        $permission = Permission::find($id);
        
        $users = User::all();
        foreach ($users as $user) {
            if($user->hasPermissionTo($permission->name)) {
                $user->revokePermissionTo($permission->name);
            }
        }

        $permission->delete();

        return response()->json('200');
    }
}
