<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepairPayment;
use App\Models\PaymentRequest;
use App\Models\RepairReply;
use App\Models\RepairStatus;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTicket;

class RepairPaymentController extends Controller
{
    //

    public function index() {
        $payments = RepairPayment::with('user', 'request')->where("verify", '1')->with('repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
        $repair_status = RepairStatus::all();

        return view("admin.repair_payment", compact('payments', 'repair_status'));
    }

    public function sendPaymentRequest(Request $request)
    {
        $query = new PaymentRequest;
        foreach($request->except('_token') as $key => $value){
            $query[$key] = $value;
        }
        
        $repair_payment = RepairPayment::where('id', '=', $request->repair_id)->first();

        if($repair_payment->payment_method == 'card') {
            $mailData = [
                'title' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_card_mail_to_user_title')),
                'description' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_card_mail_to_user_description')),
                'button' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_card_mail_to_user_button')),
                'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$request->repair_id
            ];
            
            Mail::to($repair_payment->user->email)->send(new EmailTicket($mailData));
        } else {
            $mailData = [
                'title' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_bank_mail_to_user_title')),
                'description' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_bank_mail_to_user_description')),
                'button' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_bank_mail_to_user_button')),
                'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$request->repair_id
            ];
            
            Mail::to($repair_payment->user->email)->send(new EmailTicket($mailData));
        }


        $repair_payment->save();
        $query->save();

        // Mail::to($repair_payment->user->email)->send(new EmailTicket($mailData));
        return response()->json(200);
    }

    public function detail($id) 
    {
        $repair_payment = RepairPayment::with("request")->with('bitmain')->with('user', 'repairStatus', 'reply')->where('id', '=', $id)->first();
        // $rPayment = RepairPayment::with("request")->with('reply')->with('repairStatus')->with('bitmain')->where("id", "=", $id)->first();
        $repair_payment->ischecked = 1;
        $repair_payment->save();

        return view("admin.repair_detail", compact("repair_payment"));
    }


    public function reply_edit($id,$edit_id) {

        $ticket_edit = RepairReply::where("id", $edit_id)->first();
        $repair_payment = RepairPayment::with("request")->with('bitmain')->with('user', 'repairStatus', 'reply')->where('id', '=', $id)->first();
        // $rPayment = RepairPayment::with("request")->with('reply')->with('repairStatus')->with('bitmain')->where("id", "=", $id)->first();
        $repair_payment->ischecked = 1;
        $repair_payment->save();
        
        return view("admin.repair_detail", compact("repair_payment", "ticket_edit"));
    }

    public function updateAnswer(Request $request)
    {
        // $repair_reply = new RepairReply;
        
        $repair_reply = RepairReply::where("id", "=", $request->id)->first();
        $repair_id = $request->repair_id; 


        $mailData = [
            'title' => trans('email.admin_send_reply_repair_to_user_title'),
            'description' => $request->description,
            'button' => trans('email.admin_send_reply_repair_to_user_button_label'),
            'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$repair_id
        ];
        
        Mail::to($rPayment->user->email)->send(new EmailTicket($mailData));

        foreach($request->except('_token') as $key => $value)
        {
            if($key == "file_name") {
                $value = implode(",", $value);
            } 
            if($key != "status") {
                $repair_reply[$key] = $value;
            }
        }
        
        $repair_reply->save();
        
        return response()->json(200);
    }

    public function destroy($id) 
    {
        RepairPayment::where('id', '=', $id)->delete();
        RepairReply::where("repair_id", '=', $id)->delete();
        PaymentRequest::where("repair_id", '=', $id)->delete();

        return redirect("admin/repair/payment");
    }

    public function reply_delete($id,$delete_id)
    {
        $ticket_reply = RepairReply::find($delete_id);
        $ticket_reply->delete();
        return redirect()->back()->with('success', 'Delete comment successfully');   
    }

    public function paid($id) 
    {
        $payment = PaymentRequest::where("id", '=', $id)->first();
        $payment->status = 1;
        $redirect_id = $payment->repair_id;
        $payment->save();

        return redirect("admin/repair/view/".$redirect_id);
    }

    public function unpaid($id) 
    {
        $payment = PaymentRequest::where("id", '=', $id)->first();
        $payment->status = 0;
        $redirect_id = $payment->repair_id;
        $payment->save();

        return redirect("admin/repair/view/".$redirect_id);
    }

    public function reply(Request $request)
    {
        $repair_reply = new RepairReply;
        
        $rPayment = RepairPayment::where("id", "=", $request->repair_id)->first();
        $repair_id = $request->repair_id; 


        $mailData = [
            'title' => trans('email.admin_send_reply_to_user_title'),
            'description' => $request->description,
            'button' => trans('email.admin_send_reply_to_user_button_label'),
            'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$repair_id
        ];
        
        Mail::to($rPayment->user->email)->send(new EmailTicket($mailData));

        foreach($request->except('_token') as $key => $value)
        {
            if($key == "file_name") {
                $value = implode(",", $value);
            } 
            if($key != "status") {
                $repair_reply[$key] = $value;
            }
        }
        
        $repair_reply->save();
        
        return response()->json(200);
    }

    public function updateStatus($id, $status) 
    {
        $rPayment = RepairPayment::where("id", "=", $id)->first();

        if($rPayment->status == 1) {
            $old_status = 'Incoming Repair';
        } elseif($rPayment->status == 2) {
            $old_status = 'Waiting for Shipment';
        } elseif($rPayment->status == 3) {
            $old_status = 'Pending Diagnostics';
        } elseif($rPayment->status == 4) {
            $old_status = 'Pending Client Accept';
        } elseif($rPayment->status == 5) {
            $old_status = 'Pending Client Payment';
        } elseif($rPayment->status == 6) {
            $old_status = 'Pending Repair';
        } elseif($rPayment->status == 7) {
            $old_status = 'Repair Shipped Return';
        }

        $new_status = $status;
        $rPayment->status = $status;
        
        if($rPayment->status == 1) {
            $repair_id = 'Incoming Repair'; 
        } elseif($rPayment->status == 2) {
            $repair_id = 'Waiting for Shipment'; 
        } elseif($rPayment->status == 3) {
            $repair_id = 'Pending Diagnostics'; 
        } elseif($rPayment->status == 4) {
            $repair_id = 'Pending Client Accept'; 
        } elseif($rPayment->status == 5) {
            $repair_id = 'Pending Client Payment'; 
        } elseif($rPayment->status == 6) {
            $repair_id = 'Pending Repair'; 
        } elseif($rPayment->status == 7) {
            $repair_id = 'Repair Shipped Return'; 
        }

        $mailData = [
            'title' => str_replace(array("{old_status}","{new_status}"),array($old_status,$new_status),trans('email.repair_status_update_mail_to_user_title')),
            'description' => str_replace(array("{old_status}","{new_status}"),array($old_status,$new_status),trans('email.repair_status_update_mail_to_user_description')),
            'button' => str_replace(array("{old_status}","{new_status}"),array($old_status,$new_status),trans('email.repair_status_update_mail_to_user_button')),
            'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$repair_id
        ];
        
        Mail::to($rPayment->user->email)->send(new EmailTicket($mailData));

        $rPayment->save();
        return response()->json(200);
    }
}
