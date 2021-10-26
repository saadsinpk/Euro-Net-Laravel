<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepairPayment;
use App\Models\PaymentRequest;

class RepairPaymentController extends Controller
{
    //

    public function index() {
        $payments = RepairPayment::orderBy("created_at")->get();
        
        return view("admin.repair_payment", compact('payments'));
    }

    public function sendPaymentRequest(Request $request)
    {
        $query = new PaymentRequest;
        foreach($request->except('_token') as $key => $value){
            $query[$key] = $value;
        }
        
        $repair_payment = RepairPayment::where('id', '=', $request->repair_id)->first();
        $repair_payment->status = 1;
        $repair_payment->save();
        $query->save();

        return response()->json(200);
    }


}
