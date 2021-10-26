<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepairPayment;
use DataTables;

class RepairPaymentController extends Controller
{
    //
    public function store(Request $request)
    {   
        $payment = new RepairPayment(); 

        foreach($request->except('_token') as $key => $value)
        {
            $payment[$key] = $value;
        }
        $requests = RepairPayment::get();
        $random_key = $requests->count() + 1;

        $payment->number = 'REP' . '-' . date("mdY") . str_pad($random_key, 2, "0", STR_PAD_LEFT);
        $payment->save();

        return response()->json($payment->id);
    }

    public function history() 
    {
        $requests = RepairPayment::orderBy("created_at")->get();

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
