<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\AdminLog;
use App\Models\Ticket_reply;
use App\Models\Ticket_status;
use App\Models\Category;
use App\Models\PaymentRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTicket;
use DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Tracking;

class TicketController extends Controller
{
    //
    public function index()
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_ticket'])) {
            $tickets = Ticket::with("user")->with("category")->orderBy("created_at", "DESC")->get();
            foreach ($tickets->toArray() as $key => $ticket) {
                if(is_array($ticket['user']) > 0) {
                } else {
                    unset($tickets[$key]);
                }
            }
            return view("admin.ticket.index", compact("admin_access", "tickets"));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function indexnew()
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_ticket'])) {

            $tickets = Ticket::with("user", "category")->where("status", '1')->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            foreach ($tickets->toArray() as $key => $ticket) {
                if(is_array($ticket['user']) > 0) {
                } else {
                    unset($tickets[$key]);
                }
            }
            return view("admin.ticket.index", compact("admin_access", "tickets"));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function indexopen()
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_ticket'])) {
            $tickets = Ticket::with("user")->with("category")->where("status", '2')->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            foreach ($tickets->toArray() as $key => $ticket) {
                if(is_array($ticket['user']) > 0) {
                } else {
                    unset($tickets[$key]);
                }
            }
            return view("admin.ticket.index", compact("admin_access", "tickets"));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function indexreply()
    {
        $admin_access = $this->get_current_admin_access();
            if(isset($admin_access['read_ticket'])) {
            $tickets = Ticket::with("user")->with("category")->where("status", '3')->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            foreach ($tickets->toArray() as $key => $ticket) {
                if(is_array($ticket['user']) > 0) {
                } else {
                    unset($tickets[$key]);
                }
            }
            return view("admin.ticket.index", compact("admin_access", "tickets"));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function indexpending()
    {
        $admin_access = $this->get_current_admin_access();
            if(isset($admin_access['read_ticket'])) {
            $tickets = Ticket::with("user")->with("category")->where("status", '4')->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            foreach ($tickets->toArray() as $key => $ticket) {
                if(is_array($ticket['user']) > 0) {
                } else {
                    unset($tickets[$key]);
                }
            }
            return view("admin.ticket.index", compact("admin_access", "tickets"));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function indexcomplete()
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_ticket'])) {
            $tickets = Ticket::with("user")->with("category")->where("status", '5')->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            foreach ($tickets->toArray() as $key => $ticket) {
                if(is_array($ticket['user']) > 0) {
                } else {
                    unset($tickets[$key]);
                }
            }
            return view("admin.ticket.index", compact("admin_access", "tickets"));
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function indexprocessing()
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_ticket'])) {
            $tickets = Ticket::with("user")->with("category")->where("status", '6')->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            foreach ($tickets->toArray() as $key => $ticket) {
                if(is_array($ticket['user']) > 0) {
                } else {
                    unset($tickets[$key]);
                }
            }
            return view("admin.ticket.index", compact("admin_access", "tickets"));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function reply_edit($id,$edit_id) {
        $admin_access = $this->get_current_admin_access();

        $ticket = Ticket::with("user")->with("ticket_status")->with("category")->with("reply")->where("id", $id)->where("show_ticket", '1')->first();
        $ticket_status = Ticket_status::all();
        $ticket->ischecked = 1;
        $ticket->save();
        if(isset($admin_access['reply_edit_ticket'])) {
            $ticket_edit = Ticket_reply::where("id", $edit_id)->first();
            return view("admin.ticket.show", compact("admin_access", "ticket", "ticket_status", "ticket_edit"));
        } else {
            return view("admin.ticket.show", compact("admin_access", "ticket", "ticket_status"));
        }
        
    }
    public function reply_delete($id,$delete_id)
    {
        if(isset($admin_access['reply_delete_ticket'])) {
            $admin_access = $this->get_current_admin_access();
            $ticket_reply = Ticket_reply::find($delete_id);
            $ticket = Ticket::with("ticket_status")->where("id", $ticket_reply->ticket_id)->first();

            $message = 'Ticket ID:"'.$ticket->number.'" Delete reply "'.$ticket_reply->description.'" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

            $ticket_reply->delete();
            return redirect()->back()->with('success', 'Delete comment successfully');   
        } else {
            return redirect()->back();   
        }
    }
    public function show($id)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['read_reply_ticket'])) {
            $ticket = Ticket::with("user")->with("ticket_status")->with("category")->with("reply")->where("id", $id)->where("show_ticket", '1')->first();
            $ticket_status = Ticket_status::all();
            $ticket->ischecked = 1;
            $ticket->save();
            
            return view("admin.ticket.show", compact("admin_access", "ticket", "ticket_status"));
        } else {
            return redirect()->route('dashboard');
        }
    }


    public function sendAnswer(Request $request)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['send_reply_features'])) {
            $ticket = Ticket::where("id", "=", $request->ticket_id)->first();
            if(!empty($request->description)) {
                $ticket_reply = new Ticket_reply;
                $ticket_id = $request->ticket_id;

                if(empty($ticket->selected_lang)) {
                    $ticket->selected_lang = 'en';
                }
                $mailData = [
                    'title' => trans('email.admin_send_reply_to_user_title', [], $ticket->selected_lang),
                    'description' => $request->description,
                    'button' => trans('email.admin_send_reply_to_user_button_label', [], $ticket->selected_lang),
                    'url' => 'https://euronetsupport.com/user/ticket-view/'.$ticket_id
                ];

                Mail::to($ticket->user->email)->send(new EmailTicket($mailData));
                Tracking::create(["email"=>$ticket->user->email,"button"=>json_encode($mailData)]);
                
                foreach($request->except('_token') as $key => $value)
                {
                    if($key == "file_name") {
                        $value = implode(",", $value);
                    }
                    if($key != "status") {
                        $ticket_reply[$key] = $value;
                    }
                }


                $ticket_reply->save();
            }
            $ticket_status = Ticket_status::where("id", "=", $request->status)->first();
            $message = 'Ticket ID:"'.$ticket->number.'" send reply "'.$ticket_reply->description.'" and status "'.$ticket_status->option.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"success"]);


            $ticket->flag = 0;
            $ticket->last_admin_reply = 1;
            
            $ticket->last_admin_reply_date = date('Y-m-d H:i:s');
            $ticket->status = $request->status;



            $ticket->save();
       
            return response()->json(200);
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }

    public function updateAnswer(Request $request)
    {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['reply_edit_ticket'])) {
            $ticket = Ticket::where("id", "=", $request->ticket_id)->first();
            if(!empty($request->description)) {
                $ticket_reply = Ticket_reply::where("id", $request->id)->first();
                // $ticket_reply = new Ticket_reply;
                $ticket_id = $request->ticket_id;

                // foreach($request->except('_token') as $key => $value)
                // {
                //     if($key == "file_name") {
                //         $value = implode(",", $value);
                //     }
                //     if($key != "status") {
                //         $ticket_reply[$key] = $value;
                //     }
                // }
                $ticket_reply->save();
            }

            $ticket_status = Ticket_status::where("id", "=", $request->status)->first();
            $message = 'Ticket ID:"'.$ticket->number.'" update reply "'.$ticket_reply->description.'" and status "'.$ticket_status->option.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"warning"]);


            $ticket->flag = 0;
            $ticket->status = $request->status;
            $ticket->save();
            return response()->json(200);
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
   
    }

    public function category() {
        // $admin_access = $this->get_current_admin_access();
        // $categories = Category::all();

        // if (request()->ajax()) {
        //     return DataTables::of($categories)
        //     ->addColumn('checkbox', function ($data) {
        //         $checkbox = '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
        //                         <input class="form-check-input" type="checkbox" data-kt-check="true" value="1" />
        //                         <input type="hidden" value="'.$data->id.'">
        //                     </div>';
        //         return $checkbox;
        //     })
        //     ->addColumn('action', function ($data) {
        //         return $action = '<button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-table-filter="delete_row">
        //                             <span class="svg-icon svg-icon-3">
        //                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        //                                     <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
        //                                     <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
        //                                     <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
        //                                 </svg>
        //                             </span>
        //                         </button>';
        //     })

        //     ->rawColumns(['checkbox', 'action'])
        //     ->addIndexColumn()
        //     ->make(true);
        // }
        
        // return view("admin.ticket.category", compact("admin_access", "categories"));
    }

    public function categoryStore(Request $request)
    {
        // $admin_access = $this->get_current_admin_access();
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|unique:categories',
        // ]);

        // if ($validator->fails()) {    
        //     return  response()->json(['errors'=>$validator->errors()], 422);
        // }

        // $category = new Category;

        // foreach($request->except('_token') as $key => $value)
        // {
        //     $category[$key] = $value;
        // }
        // $category->save();
        // return response()->json(200);
    }

    public function destroy ($id) {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['delete_ticket'])) {
            $ticket = Ticket::find($id);

            $message = 'Delete Ticket ID:"'.$ticket->number.'"  from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"danger"]);

            $ticket->delete();

            return redirect()->back()->with('success', 'your message,here');   
        } else {
            return redirect()->back();
        }
    }

    public function destroyRows(Request $request) {
        // $admin_access = $this->get_current_admin_access();
        // Category::whereIn("id", explode(",", $request->ids))->delete();
        // return response()->json('200');
    }

    public function invice() {
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['view_invoice'])) {
            $invoices = PaymentRequest::with("repairPayment")->with('user')->orderBy("created_at", "DESC")->get();
            return view("admin.invoice", compact("admin_access", "invoices"));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function updateStatus($id,$status){
        $admin_access = $this->get_current_admin_access();
        if(isset($admin_access['update_status_ticket'])) {
            $ticket = Ticket::where("id", "=", $id)->first();

            $ticket_status = Ticket_status::where("id", "=", $status)->first();
            $message = 'Ticket Status update Ticket ID:"'.$ticket->number.'" to:"'.$ticket_status->option.'" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
            AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"warning"]);

            $ticket->status = $status;
            $ticket->save();

            return response()->json(200);
        } else {
            return  response()->json(['errors'=>'Sorry! You are not allow'], 400);
        }
    }
}
