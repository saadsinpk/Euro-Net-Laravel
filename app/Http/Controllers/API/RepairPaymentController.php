<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\PaymentRequest;
use App\Models\RepairNotes;
use App\Models\RepairPayment;
use App\Models\RepairReply;
use App\Models\RepairStatus;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RepairPaymentController extends BaseController
{
    public function index()
    {

        $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
        $repair_status = RepairStatus::all();
        $success['data'] = $payments;
        $success1['data'] = $repair_status;
        return $this->sendResponse($success, $success1);

    }

    public function detail(Request $request, $id)
    {
        $repair_payment = RepairPayment::with('notes', 'user', 'repairStatus', 'reply', 'request', 'bitmain')->where('id', '=', $id)->first();
        $repair_payment->ischecked = 1;
        $repair_payment->save();
        $success = $repair_payment;
        return $this->sendResponse($success, 'Repair requests.');

    }

    public function updateStatus($id, $status)
    {

        $rPayment = RepairPayment::where("id", "=", $id)->first();

        if ($rPayment->status == 1) {
            $old_status = 'Incoming Repair';
        } elseif ($rPayment->status == 2) {
            $old_status = 'Waiting for Shipment';
        } elseif ($rPayment->status == 3) {
            $old_status = 'Pending Diagnostics';
        } elseif ($rPayment->status == 4) {
            $old_status = 'Pending Client Accept';
        } elseif ($rPayment->status == 5) {
            $old_status = 'Pending Client Payment';
        } elseif ($rPayment->status == 6) {
            $old_status = 'Pending Repair';
        } elseif ($rPayment->status == 7) {
            $old_status = 'Repair Shipped Return';
        } elseif ($rPayment->status == 8) {
            $old_status = 'Repair Canceled';
        }

        $rPayment->status = $status;

        if ($rPayment->status == 1) {
            $new_status = 'Incoming Repair';
        } elseif ($rPayment->status == 2) {
            $new_status = 'Waiting for Shipment';
        } elseif ($rPayment->status == 3) {
            $new_status = 'Pending Diagnostics';
        } elseif ($rPayment->status == 4) {
            $new_status = 'Pending Client Accept';
        } elseif ($rPayment->status == 5) {
            $new_status = 'Pending Client Payment';
        } elseif ($rPayment->status == 6) {
            $new_status = 'Pending Repair';
        } elseif ($rPayment->status == 7) {
            $new_status = 'Repair Shipped Return';
        } elseif ($rPayment->status == 8) {
            $new_status = 'Repair Canceled';
        }

        $mailData = [
            'title' => str_replace(array("{old_status}", "{new_status}"), array($old_status, $new_status), trans('email.repair_status_update_mail_to_user_title')),
            'description' => str_replace(array("{old_status}", "{new_status}"), array($old_status, $new_status), trans('email.repair_status_update_mail_to_user_description')),
            'button' => str_replace(array("{old_status}", "{new_status}"), array($old_status, $new_status), trans('email.repair_status_update_mail_to_user_button')),
            'url' => 'https://euronetsupport.com/user/repair_payment/view/' . $rPayment->id
        ];

        $success = $new_status;
        return $this->sendResponse($success, 'Repair status updated.');
    }

    public function destroy($id)
    {
        $RepairPayment = RepairPayment::find($id);
        RepairReply::where("repair_id", '=', $id)->delete();
        PaymentRequest::where("repair_id", '=', $id)->delete();

        $message = 'Delete Repair ID:"' . $RepairPayment->number . '"  from IP:' . \Request::ip() . ' at ' . date("F j, Y, g:i a");
        $RepairPayment->delete();

        $success = $message;
        return $this->sendResponse($success, 'successfully.');
    }

    public function edit($id)
    {
        $repair_payment = RepairPayment::with("request")->with('bitmain')->with('user', 'repairStatus', 'reply')->where('id', '=', $id)->first();
        $repair_payment->ischecked = 1;
        $repair_payment->save();

        $success = $repair_payment;
        return $this->sendResponse($success, 'successfully.');
    }

//    public function notes(Request $request)
//    {
//        $notes = RepairNotes::all();
//        $success = $notes;
//        return $this->sendResponse($success, 'successfully.');
//
//    }

    public function repair_notes(Request $request)
    {

        $repair_notes = new RepairNotes;
        $repair_id = $request->repair_id;

        foreach ($request->except('_token') as $key => $value) {
            if ($key == "file_name") {
                $value = implode(",", $value);
            }
            if ($key != "status") {
                $repair_notes[$key] = $value;
            }
        }

        $RepairPayment = RepairPayment::find($repair_id);
        $message = 'Add note to Repair ID: "' . $RepairPayment->number . '" Note: "' . $repair_notes->description . '"  from IP:' . \Request::ip() . ' at ' . date("F j, Y, g:i a");
        $success = $message;
        return $this->sendResponse($success, 'successfully.');

    }

    public function notes_edit(Request $request, $id, $edit_id)
    {
            RepairPayment::where("id", "=", $id)->update(["return_tracking_number" => $request->return_tracking_number, "return_shipping_company" => $request->return_shipping_company]);


            $notes_ticket_edit = RepairNotes::where("id", $edit_id)->first();
            $repair_payment = RepairPayment::with('notes', 'user', 'repairStatus', 'reply', 'request', 'bitmain')->where('id', '=', $id)->first();

            $success = $notes_ticket_edit;
            return $this->sendResponse($success, 'successfully.');


    }
    public function notes_delete($id,$delete_id)
    {
            $ticket_notes = RepairNotes::find($delete_id);
            $ticket_notes->delete();
            $success = $delete_id;
            return $this->sendResponse($success, 'successfully.');
    }
    public function payment_delete($id,$delete_id)
    {
            $payment = PaymentRequest::find($delete_id);
            $RepairPayment = RepairPayment::find($payment->repair_id);

            $message = 'Delete Repair Payment Repair ID:"'.$RepairPayment->number.'" Amount "'.$payment->amount.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");

            $payment->delete();
            $payment = PaymentRequest::where("id", "=", $delete_id)->delete();


            $success = $delete_id;
            return $this->sendResponse($success, 'successfully.');
    }
    public function edit_payment(Request $request, $id,$edit_id)
    {
//        $admin_access = $this->get_current_admin_access();
//        if(isset($admin_access['edit_repair_payment'])) {
//            if(isset($_POST['update_shipping'])) {
                RepairPayment::where("id", "=", $id)->update(["return_tracking_number"=>$request->return_tracking_number,"return_shipping_company"=>$request->return_shipping_company]);
//            }

//            if(isset($_POST['update_payment'])) {
                PaymentRequest::where("id", "=", $edit_id)->update(["description"=>$request->description,"amount"=>number_format($request->amount, 2, '.', ''),"status"=>$request->payment_status]);

//            }

            $repair_payment = RepairPayment::with('notes', 'user', 'repairStatus', 'reply', 'bitmain', 'request')->where('id', '=', $id)->first();


        $success = $repair_payment;
        return $this->sendResponse($success, 'successfully.');
    }

    public function create(Request $request)
    {
        $repair_payment = new RepairPayment();
        $repair_payment->number = $request->number;
        $repair_payment->serial_num = $request->serial_num;
        $repair_payment->problem = $request->problem;
        $repair_payment->bitmain_id = $request->bitmain_id;
        $repair_payment->user_id = $request->user_id;
        $repair_payment->status = $request->status;
        $repair_payment->verify = $request->verify;
        $repair_payment->ischecked = $request->ischecked;
        $repair_payment->address = $request->address;
        $repair_payment->street = $request->street;
        $repair_payment->city = $request->city;
        $repair_payment->country = $request->country;
        $repair_payment->postalcode = $request->postalcode;
        $repair_payment->payment_method = $request->payment_method;
        $repair_payment->selected_lang = $request->selected_lang;
        $repair_payment->shipping_from = $request->shipping_from;
        $repair_payment->shipping_to = $request->shipping_to;
        $repair_payment->return_shipping_from = $request->return_shipping_from;
        $repair_payment->return_shipping_to = $request->return_shipping_to;
        $repair_payment->tracking_number = $request->tracking_number;
        $repair_payment->shipping_company = $request->shipping_company;
        $repair_payment->ship_attach = $request->ship_attach;
        $repair_payment->return_ship_attach = $request->return_ship_attach;
        $repair_payment->last_admin_reply = $request->last_admin_reply;
        $repair_payment->last_admin_reply_date = $request->last_admin_reply_date;
        $repair_payment->return_tracking_number = $request->return_tracking_number;
        $repair_payment->return_shipping_company = $request->return_shipping_company;
        $repair_payment->label = $request->label;
        $repair_payment->return_label = $request->return_label;
        $repair_payment->save();

        $success = $repair_payment;
        return $this->sendResponse($success, 'inserted successfully.');
    }
    public function notes(Request $request)
    {

            $repair_notes = new RepairNotes;
            $repair_id = $request->repair_id;

            foreach($request->except('_token') as $key => $value)
            {
                if($key == "file_name") {
                    $value = implode(",", $value);
                }
                if($key != "status") {
                    $repair_notes[$key] = $value;
                }
            }

            $RepairPayment = RepairPayment::find($repair_id);
            $message = 'Add note to Repair ID: "'.$RepairPayment->number.'" Note: "'.$repair_notes->description.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");

            $repair_notes->save();

        $success = $repair_notes;
        return $this->sendResponse($success, 'send successfully.');

    }
}
