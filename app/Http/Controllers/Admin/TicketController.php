<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Ticket_reply;
use App\Models\Ticket_status;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTicket;
use DataTables;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    //
    public function index()
    {
        $tickets = Ticket::with("user")->with("category")->orderBy("created_at", "DESC")->get();
        return view("admin.ticket.index", compact("tickets"));
    }
    public function indexnew()
    {
        $tickets = Ticket::with("user")->with("category")->where("status", '1')->where("show_ticket", '1')->orderBy("created_at", "DESC")->paginate(10);
        return view("admin.ticket.index", compact("tickets"));
    }
    public function indexopen()
    {
        $tickets = Ticket::with("user")->with("category")->where("status", '2')->where("show_ticket", '1')->orderBy("created_at", "DESC")->paginate(10);
        return view("admin.ticket.index", compact("tickets"));
    }
    public function indexreply()
    {
        $tickets = Ticket::with("user")->with("category")->where("status", '3')->where("show_ticket", '1')->orderBy("created_at", "DESC")->paginate(10);
        return view("admin.ticket.index", compact("tickets"));
    }
    public function indexpending()
    {
        $tickets = Ticket::with("user")->with("category")->where("status", '4')->where("show_ticket", '1')->orderBy("created_at", "DESC")->paginate(10);
        return view("admin.ticket.index", compact("tickets"));
    }
    public function indexcomplete()
    {
        $tickets = Ticket::with("user")->with("category")->where("status", '5')->where("show_ticket", '1')->orderBy("created_at", "DESC")->paginate(10);
        return view("admin.ticket.index", compact("tickets"));
    }
    public function indexprocessing()
    {
        $tickets = Ticket::with("user")->with("category")->where("status", '6')->where("show_ticket", '1')->orderBy("created_at", "DESC")->paginate(10);
        return view("admin.ticket.index", compact("tickets"));
    }

    public function show($id)
    {
        $ticket = Ticket::with("user")->with("ticket_status")->with("category")->with("reply")->where("id", $id)->where("show_ticket", '1')->first();
        $ticket_status = Ticket_status::all();
        return view("admin.ticket.show", compact("ticket", "ticket_status"));
    }


    public function sendAnswer(Request $request)
    {
        $ticket_reply = new Ticket_reply;
        $ticket = Ticket::where("id", "=", $request->ticket_id)->first();
        $ticket_id = $request->ticket_id;

        $mailData = [
            'title' => trans('email.admin_send_reply_to_user_title'),
            'description' => $request->description,
            'button' => trans('email.admin_send_reply_to_user_button_label'),
            'url' => 'https://euronetsupport.com/user/ticket-view/'.$ticket_id
        ];

        Mail::to($ticket->user->email)->send(new EmailTicket($mailData));
        
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


        $ticket->flag = 0;
        $ticket->status = $request->status;
        $ticket->save();
   
        return response()->json(200);
    }

    public function category() {
        $categories = Category::all();

        if (request()->ajax()) {
            return DataTables::of($categories)
            ->addColumn('checkbox', function ($data) {
                $checkbox = '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" value="1" />
                                <input type="hidden" value="'.$data->id.'">
                            </div>';
                return $checkbox;
            })
            ->addColumn('action', function ($data) {
                return $action = '<button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-table-filter="delete_row">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"></path>
                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"></path>
                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"></path>
                                        </svg>
                                    </span>
                                </button>';
            })

            ->rawColumns(['checkbox', 'action'])
            ->addIndexColumn()
            ->make(true);
        }
        
        return view("admin.ticket.category", compact("categories"));
    }

    public function categoryStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',
        ]);

        if ($validator->fails()) {    
            return  response()->json(['errors'=>$validator->errors()], 422);
        }

        $category = new Category;

        foreach($request->except('_token') as $key => $value)
        {
            $category[$key] = $value;
        }

        $category->save();

        return response()->json(200);
    }

    public function destroy ($id) {
        $ticket = Ticket::find($id);
        $ticket->delete();

        return redirect()->back()->with('success', 'your message,here');   
    }

    public function destroyRows(Request $request) {
        Category::whereIn("id", explode(",", $request->ids))->delete();
        return response()->json('200');
    }
}
