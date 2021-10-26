<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BitMain;
use DataTables;

class BitmainController extends Controller
{
    //

    public function index() 
    {
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
                $action = 
                    '<a href="#" class="btn btn-sm btn-light btn-active-light-primary btn-action" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">'.trans('form.Actions').'
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                            </svg>
                        </span>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="'.url("/admin/admins/view/$data->id").'" class="menu-link px-3">'.trans('form.Edit').'</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-table-filter="delete_row">'.trans('form.Delete').'</a>
                        </div>
                    </div>';

                return $action;
            })

            ->rawColumns(['checkbox', 'action', 'created_at'])
            ->addIndexColumn()
            ->make(true);
        }

        return view("admin.bitmain");
    }

    public function store(Request $request) 
    {
        $bitmain = new BitMain;

        $bitmain->name = $request->name;

        $bitmain->save();

        return response()->json(200);
    }

    public function destroy ($id) {
        $query = BitMain::find($id);
        $query->delete();

        return response()->json('200');
    }

    public function destroyRows(Request $request) {
        $query = BitMain::whereIn("id", explode(",", $request->ids))->delete();

        return response()->json('200');
    }
}
