<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepairPayment;
use App\Models\PaymentRequest;
use App\Models\AdminLog;
use App\Models\RepairReply;
use App\Models\RepairStatus;
use App\Models\RepairNotes;
use App\Models\User;
use App\Models\BitMain;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTicket;
use App\Models\Tracking;


class RepairPaymentController extends Controller
{
    //

    public function index() {
        $admin_access = $this->get_current_admin_access();

        if(isset($admin_access['read_repair'])) {
            $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            return view("admin.repair_payment", compact('payments', 'repair_status', 'admin_access'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function index_incoming() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_repair'])) {

            $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            foreach ($payments->toArray() as $key => $payment) {
                if($payment['repair_status']['id'] == 1) {
                } else {
                    unset($payments[$key]);
                }
            }

            return view("admin.repair_payment", compact('payments', 'repair_status', 'admin_access'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function index_waiting_ship() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_repair'])) {

            $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            foreach ($payments->toArray() as $key => $payment) {
                if($payment['repair_status']['id'] == 2) {
                } else {
                    unset($payments[$key]);
                }
            }

            return view("admin.repair_payment", compact('payments', 'repair_status', 'admin_access'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function index_diagnostics() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_repair'])) {

            $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            foreach ($payments->toArray() as $key => $payment) {
                if($payment['repair_status']['id'] == 3) {
                } else {
                    unset($payments[$key]);
                }
            }

            return view("admin.repair_payment", compact('payments', 'repair_status', 'admin_access'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function index_client_accept() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_repair'])) {

            $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            foreach ($payments->toArray() as $key => $payment) {
                if($payment['repair_status']['id'] == 4) {
                } else {
                    unset($payments[$key]);
                }
            }

            return view("admin.repair_payment", compact('payments', 'repair_status', 'admin_access'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function index_pending_payment() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_repair'])) {

            $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            foreach ($payments->toArray() as $key => $payment) {
                if($payment['repair_status']['id'] == 5) {
                } else {
                    unset($payments[$key]);
                }
            }

            return view("admin.repair_payment", compact('payments', 'repair_status', 'admin_access'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function index_pending() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_repair'])) {

            $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            foreach ($payments->toArray() as $key => $payment) {
                if($payment['repair_status']['id'] == 6) {
                } else {
                    unset($payments[$key]);
                }
            }

            return view("admin.repair_payment", compact('payments', 'repair_status', 'admin_access'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function index_ship_return() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_repair'])) {

            $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            foreach ($payments->toArray() as $key => $payment) {
                if($payment['repair_status']['id'] == 7) {
                } else {
                    unset($payments[$key]);
                }
            }

            return view("admin.repair_payment", compact('payments', 'repair_status', 'admin_access'));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function index_canceled() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_repair'])) {

            $payments = RepairPayment::with('user', 'request', 'repairStatus')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            $repair_status = RepairStatus::all();

            foreach ($payments->toArray() as $key => $payment) {
                if($payment['repair_status']['id'] == 8) {
                } else {
                    unset($payments[$key]);
                }
            }

            return view("admin.repair_payment", compact('payments', 'repair_status', 'admin_access'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function sendPaymentRequest(Request $request)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['send_repair_payment'])) {
            $query = new PaymentRequest;
            foreach($request->except('_token') as $key => $value){
                $query[$key] = $value;
            }
            
            $repair_payment = RepairPayment::where('id', '=', $request->repair_id)->first();


            if(empty($repair_payment->selected_lang)) {
                $repair_payment->selected_lang = 'en';
            }
            
            if($repair_payment->payment_method == 'card') {
                $mailData = [
                    'title' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_card_mail_to_user_title', [], $repair_payment->selected_lang)),
                    'description' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_card_mail_to_user_description', [], $repair_payment->selected_lang)),
                    'button' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_card_mail_to_user_button', [], $repair_payment->selected_lang)),
                    'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$request->repair_id
                ];
                
                Mail::to($repair_payment->user->email)->send(new EmailTicket($mailData));
                Tracking::create(["email"=>$repair_payment->user->email,"button"=>json_encode($mailData)]);
            } else {
                $mailData = [
                    'title' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_bank_mail_to_user_title', [], $repair_payment->selected_lang)),
                    'description' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_bank_mail_to_user_description', [], $repair_payment->selected_lang)),
                    'button' => str_replace('{amount}',$request->amount,trans('email.repair_send_payment_bank_mail_to_user_button', [], $repair_payment->selected_lang)),
                    'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$request->repair_id
                ];
                
                Mail::to($repair_payment->user->email)->send(new EmailTicket($mailData));
                Tracking::create(["email"=>$repair_payment->user->email,"button"=>json_encode($mailData)]);
            }

            $message = 'Send Payment Request Repair ID:"'.$repair_payment->number.'" Amount "'.$request->amount.'" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"success"]);

            $repair_payment->save();
            $query->save();

            // Mail::to($repair_payment->user->email)->send(new EmailTicket($mailData));
            return response()->json(200);
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }

    public function detail(Request $request, $id) 
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_repair'])) {
            if(isset($_POST['update_shipping'])) {
                RepairPayment::where("id", "=", $id)->update(["return_tracking_number"=>$request->return_tracking_number,"return_shipping_company"=>$request->return_shipping_company]);
            }

            $repair_payment = RepairPayment::with('notes', 'user', 'repairStatus', 'reply', 'request', 'bitmain')->where('id', '=', $id)->first();
            $repair_payment->ischecked = 1;
            $repair_payment->save();

            return view("admin.repair__detail", compact("repair_payment", "admin_access"));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function edit($id) 
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['edit_repair'])) {
            if(isset($_POST['street'])) {
                $RepairPayment = RepairPayment::where("id", "=", $id)->first();
                $RepairPayment->street = $_POST['street'];
                $RepairPayment->city = $_POST['city'];
                $RepairPayment->country = $_POST['country'];
                $RepairPayment->postalcode = $_POST['postalcode'];
                $RepairPayment->payment_method = $_POST['payment_method'];
                $RepairPayment->serial_num = $_POST['serial_num'];
                $RepairPayment->bitmain_id = $_POST['bitmain_id'];
                $RepairPayment->problem = $_POST['problem'];
                $RepairPayment->save();

                $message = 'Update Repair ID:"'.$RepairPayment->number.'" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
                AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"warning"]);
            }
            $bitmain = BitMain::all();
            $repair_payment = RepairPayment::with("request")->with('bitmain')->with('user', 'repairStatus', 'reply')->where('id', '=', $id)->first();
            // $rPayment = RepairPayment::with("request")->with('reply')->with('repairStatus')->with('bitmain')->where("id", "=", $id)->first();
            $repair_payment->ischecked = 1;
            $repair_payment->save();

            return view("admin.repair_edit", compact("repair_payment", "bitmain", "admin_access"));
        } else {
            return redirect()->back();   
        }
    }


    public function reply_edit(Request $request, $id,$edit_id) {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['edit_repair_reply'])) {
            if(isset($_POST['update_shipping'])) {
                RepairPayment::where("id", "=", $id)->update(["return_tracking_number"=>$request->return_tracking_number,"return_shipping_company"=>$request->return_shipping_company]);
            }

            $ticket_edit = RepairReply::where("id", $edit_id)->first();
            $repair_payment = RepairPayment::with('notes', 'user', 'repairStatus', 'reply', 'request', 'bitmain')->where('id', '=', $id)->first();
            $repair_payment->ischecked = 1;
            $repair_payment->save();
            
            return view("admin.repair__detail", compact("repair_payment", "ticket_edit", "admin_access"));
        } else {
            return redirect()->back();   
        }
    }

    public function updateAnswer(Request $request)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['edit_repair_reply'])) {
            // $repair_reply = new RepairReply;
            
            $repair_reply = RepairReply::where("id", "=", $request->id)->first();
            $repair_id = $request->repair_id; 

            // $mailData = [
            //     'title' => trans('email.admin_send_reply_repair_to_user_title'),
            //     'description' => $request->description,
            //     'button' => trans('email.admin_send_reply_repair_to_user_button_label'),
            //     'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$repair_id
            // ];
            
            // Mail::to($rPayment->user->email)->send(new EmailTicket($mailData));

            foreach($request->except('_token') as $key => $value)
            {
                if($key == "file_name") {
                    $value = implode(",", $value);
                } 
                if($key != "status") {
                    $repair_reply[$key] = $value;
                }
            }

            $RepairPayment = RepairPayment::find($repair_id);

            $message = 'Update Repair Reply Repair ID:"'.$RepairPayment->number.'" new reply "'.$repair_reply->description.'" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"warning"]);
            
            $repair_reply->save();
            
            return response()->json(200);
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }

    public function destroy($id) 
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['delete_repair'])) {
            $RepairPayment = RepairPayment::find($id);
            RepairReply::where("repair_id", '=', $id)->delete();
            PaymentRequest::where("repair_id", '=', $id)->delete();

            $message = 'Delete Repair ID:"'.$RepairPayment->number.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

            $RepairPayment->delete();

            return redirect("admin/repair/payment");
        }
    }

    public function edit_payment(Request $request, $id,$edit_id)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['edit_repair_payment'])) {
            if(isset($_POST['update_shipping'])) {
                RepairPayment::where("id", "=", $id)->update(["return_tracking_number"=>$request->return_tracking_number,"return_shipping_company"=>$request->return_shipping_company]);
            }

            if(isset($_POST['update_payment'])) {
                PaymentRequest::where("id", "=", $edit_id)->update(["description"=>$request->description,"amount"=>number_format($request->amount, 2, '.', ''),"status"=>$request->payment_status]);
                return redirect(url('/admin/repair/view/'.$id));   
            }

            $payment_edit = $edit_id;
            $repair_payment = RepairPayment::with('notes', 'user', 'repairStatus', 'reply', 'bitmain', 'request')->where('id', '=', $id)->first();

            return view("admin.repair__detail", compact("repair_payment", "payment_edit", "admin_access"));
        } else {
            return redirect()->back();   
        }
    }

    public function payment_delete($id,$delete_id)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['delete_repair_payment'])) {

            $payment = PaymentRequest::find($delete_id);
            $RepairPayment = RepairPayment::find($payment->repair_id);

            $message = 'Delete Repair Payment Repair ID:"'.$RepairPayment->number.'" Amount "'.$payment->amount.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

            $payment->delete();
            $payment = PaymentRequest::where("id", "=", $delete_id)->delete();

            return redirect()->back()->with('success', 'Delete payment successfully');   
        } else {
            return redirect()->back();
        }
    }

    public function reply_delete($id,$delete_id)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['delete_repair_reply'])) {
            $ticket_reply = RepairReply::find($delete_id);

            $RepairPayment = RepairPayment::find($ticket_reply->repair_id);

            $message = 'Delete Repair reply Repair ID:"'.$RepairPayment->number.'" Reply was "'.$ticket_reply->description.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

            $ticket_reply->delete();
            return redirect()->back()->with('success', 'Delete comment successfully');   
        } else {
            return redirect()->back();
        }
    }

    // public function paid($id) 
    // {
    //     $admin_access = $this->get_current_admin_access();
    //     if(isset($admin_access['update_repair_payment_status'])) {
    //         $payment = PaymentRequest::where("id", '=', $id)->first();
    //         $payment->status = 1;
    //         $redirect_id = $payment->repair_id;
    //         $payment->save();
    //     }

    //     return redirect("admin/repair/view/".$redirect_id);
    // }

    // public function unpaid($id) 
    // {
    //     $admin_access = $this->get_current_admin_access();
    //     if(isset($admin_access['update_repair_payment_status'])) {
    //         $payment = PaymentRequest::where("id", '=', $id)->first();
    //         $payment->status = 0;
    //         $redirect_id = $payment->repair_id;
    //         $payment->save();
    //     }

    //     return redirect("admin/repair/view/".$redirect_id);
    // }

    public function notes(Request $request)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['send_repair_notes'])) {
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
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);
            
            $repair_notes->save();
            
            return response()->json(200);
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }

    public function updateNotes(Request $request)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['edit_repair_notes'])) {

            $repair_notes = RepairNotes::where("id", "=", $request->id)->first();
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
            $message = 'Update note to Repair ID: "'.$RepairPayment->number.'" Note: "'.$repair_notes->description.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

            $repair_notes->save();
            
            return response()->json(200);
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }

    public function notes_delete($id,$delete_id)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['delete_repair_notes'])) {
            $ticket_notes = RepairNotes::find($delete_id);

            $RepairPayment = RepairPayment::find($ticket_notes->repair_id);
            $message = 'Delete note from Repair ID: "'.$RepairPayment->number.'" Note: "'.$ticket_notes->description.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);


            $ticket_notes->delete();
            return redirect()->back()->with('success', 'Delete comment successfully');   
        } else {
            return redirect()->back();   
        }
    }

    public function notes_edit(Request $request, $id,$edit_id) {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['edit_repair_notes'])) {

            if(isset($_POST['update_shipping'])) {
                RepairPayment::where("id", "=", $id)->update(["return_tracking_number"=>$request->return_tracking_number,"return_shipping_company"=>$request->return_shipping_company]);
            }

            $notes_ticket_edit = RepairNotes::where("id", $edit_id)->first();
            $repair_payment = RepairPayment::with('notes', 'user', 'repairStatus', 'reply', 'request', 'bitmain')->where('id', '=', $id)->first();
            
            return view("admin.repair__detail", compact("repair_payment", "notes_ticket_edit", "admin_access"));
        } else {
            return redirect()->back();   
        }
    }

    public function reply(Request $request)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['send_repair_reply'])) {
            $repair_reply = new RepairReply;
            
            $rPayment = RepairPayment::where("id", "=", $request->repair_id)->first();
            $repair_id = $request->repair_id; 


            if(empty($rPayment->selected_lang)) {
                $rPayment->selected_lang = 'en';
            }
            $mailData = [
                'title' => trans('email.admin_send_reply_to_user_title', [], $rPayment->selected_lang),
                'description' => $request->description,
                'button' => trans('email.admin_send_reply_to_user_button_label', [], $rPayment->selected_lang),
                'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$repair_id
            ];
            
            Mail::to($rPayment->user->email)->send(new EmailTicket($mailData));
            Tracking::create(["email"=>$rPayment->user->email,"button"=>json_encode($mailData)]);

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
            $rPayment->last_admin_reply = 1;
            $rPayment->last_admin_reply_date = date('Y-m-d H:i:s');
            $rPayment->save();

            $message = 'Send reply on Repair ID: "'.$rPayment->number.'" Reply: "'.$repair_reply->description.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);
            
            return response()->json(200);
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }

    public function updateStatus($id, $status) 
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['update_repair_status'])) {

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
            } elseif($rPayment->status == 8) {
                $old_status = 'Repair Canceled';
            }

            $rPayment->status = $status;
            
            if($rPayment->status == 1) {
                $new_status = 'Incoming Repair'; 
            } elseif($rPayment->status == 2) {
                $new_status = 'Waiting for Shipment'; 
            } elseif($rPayment->status == 3) {
                $new_status = 'Pending Diagnostics'; 
            } elseif($rPayment->status == 4) {
                $new_status = 'Pending Client Accept'; 
            } elseif($rPayment->status == 5) {
                $new_status = 'Pending Client Payment'; 
            } elseif($rPayment->status == 6) {
                $new_status = 'Pending Repair'; 
            } elseif($rPayment->status == 7) {
                $new_status = 'Repair Shipped Return'; 
            } elseif($rPayment->status == 8) {
                $new_status = 'Repair Canceled'; 
            }

            $mailData = [
                'title' => str_replace(array("{old_status}","{new_status}"),array($old_status,$new_status),trans('email.repair_status_update_mail_to_user_title')),
                'description' => str_replace(array("{old_status}","{new_status}"),array($old_status,$new_status),trans('email.repair_status_update_mail_to_user_description')),
                'button' => str_replace(array("{old_status}","{new_status}"),array($old_status,$new_status),trans('email.repair_status_update_mail_to_user_button')),
                'url' => 'https://euronetsupport.com/user/repair_payment/view/'.$rPayment->id
            ];
            
            Mail::to($rPayment->user->email)->send(new EmailTicket($mailData));
            Tracking::create(["email"=>$rPayment->user->email,"button"=>json_encode($mailData)]);
            $rPayment->save();

            $message = 'Update Status on Repair ID: "'.$rPayment->number.'" New Status: "'.$new_status.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

            return response()->json(200);
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }
}
