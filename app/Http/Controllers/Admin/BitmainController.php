<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BitMain;
use App\Models\AdminLog;
use DataTables;

class BitmainController extends Controller
{
    //

    public function index() 
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_bitmain'])) {
            $bitmain = BitMain::all();

            if (request()->ajax()) {
                return DataTables::of($bitmain)

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
                    $action = 
                        '<a href="#" class="btn btn-sm btn-light btn-active-light-primary btn-action" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'.trans('form.Actions').'
                            <span class="svg-icon svg-icon-5 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                </svg>
                            </span>
                        </a>';
                        if(isset($admin_access['delete_bitmain'])) {
                            $action .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-table-filter="delete_row">'.trans('form.Delete').'</a>
                                </div>
                            </div>';
                        }

                    return $action;
                })

                ->rawColumns(['checkbox', 'action', 'created_at'])
                ->addIndexColumn()
                ->make(true);
            }
            return view("admin.bitmain", compact("admin_access"));
        } else {
            return redirect()->route('dashboard');
        }

    }

    public function store(Request $request) 
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['add_bitmain'])) {
            $bitmain = new BitMain;

            $bitmain->name = $request->name;

            $bitmain->save();
            $message = 'Create Bitmain "'.$request->name.'" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"success"]);

            return response()->json(200);
        } else{
            return  response()->json(['errors'=>'Sorry! You are not allow'], 422);
        }
    }

    public function destroy ($id) {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['delete_bitmain'])) {
            $query = BitMain::find($id);

            $message = 'Delete Bitmain "'.$query->name.'" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

            $query->delete();

            return response()->json('200');
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 422);
        }
    }

    public function destroyRows(Request $request) {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['delete_bitmain'])) {
            $request->ids = explode(",",$request->ids);
            foreach ($request->ids as $key => $value_id) {

                $query = BitMain::find($value_id);
                $message = 'Delete Bitmain "'.$query->name.'" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
                AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

                $query->delete();
            }
            return response()->json('200');
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 422);
        }
    }
}
