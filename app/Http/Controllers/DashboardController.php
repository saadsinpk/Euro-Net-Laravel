<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\Fileupload;
use App\Models\Ticket_status;
use App\Models\BitMain;

class DashboardController extends Controller
{
    //

    public function index()
    {
        $admin_access = $this->get_current_admin_access();

        $users = User::role('user')->where("verify", "=", "1")->get();
        $categories = Category::all();
        $tickets_new = Ticket::with("user")->where("status", "=", "1")->where("show_ticket", "=", "1")->get();
        foreach ($tickets_new->toArray() as $key => $ticket_new) {
            if(is_array($ticket_new['user']) > 0) {
            } else {
                unset($tickets_new[$key]);
            }
        }
        $tickets_new = $tickets_new->count();
        $tickets_opening = Ticket::with("user")->where("status", "=", "2")->where("show_ticket", "=", "1")->get();
        foreach ($tickets_opening->toArray() as $key => $ticket_opening) {
            if(is_array($ticket_opening['user']) > 0) {
            } else {
                unset($tickets_opening[$key]);
            }
        }
        $tickets_opening = $tickets_opening->count();

        $tickets_reply = Ticket::with("user")->where("status", "=", "3")->where("show_ticket", "=", "1")->get();
        foreach ($tickets_reply->toArray() as $key => $ticket_reply) {
            if(is_array($ticket_reply['user']) > 0) {
            } else {
                unset($tickets_reply[$key]);
            }
        }
        $tickets_reply = $tickets_reply->count();
        $tickets_processing = Ticket::with("user")->where("status", "=", "6")->where("show_ticket", "=", "1")->get();
        foreach ($tickets_processing->toArray() as $key => $ticket_processing) {
            if(is_array($ticket_processing['user']) > 0) {
            } else {
                unset($tickets_processing[$key]);
            }
        }
        $tickets_processing = $tickets_processing->count();

        $tickets_pending = Ticket::with("user")->where("status", "=", "4")->where("show_ticket", "=", "1")->get();
        foreach ($tickets_pending->toArray() as $key => $ticket_pending) {
            if(is_array($ticket_pending['user']) > 0) {
            } else {
                unset($tickets_pending[$key]);
            }
        }
        $tickets_pending = $tickets_pending->count();

        $tickets_complete = Ticket::with("user")->where("status", "=", "5")->where("show_ticket", "=", "1")->get();
        foreach ($tickets_complete->toArray() as $key => $ticket_complete) {
            if(is_array($ticket_complete['user']) > 0) {
            } else {
                unset($tickets_complete[$key]);
            }
        }
        $tickets_complete = $tickets_complete->count();

        $bitmain = BitMain::all();
        if(auth()->user()) {
            if(auth()->user()->hasRole("admin")) {
                return view("dashboard", compact("users", "tickets_new", "tickets_opening", "tickets_reply", "tickets_processing", "tickets_pending", "tickets_complete", "admin_access"));
            }else {
                return view("user.ticket", compact("categories", "bitmain"));
            }
        }else {
            return view("user.ticket", compact("categories", "bitmain"));
        }
    }

    public function fileUpload(Request $request)
    {   
        $admin_access = $this->get_current_admin_access();
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('uploads/attached'),$fileName);
        
        $fileupload = new Fileupload();

        $fileupload->file_name = $fileName;
        $fileupload->save();

        return response()->json(['file_name'=>$fileName]);

        dd($request->all());
    }

    public function fileRemove(Request $request) 
    {
        $admin_access = $this->get_current_admin_access();
        $filename =  $request->get('filename');
        Fileupload::where('file_name', "=", $filename)->delete();
        
        $path=public_path().'/uploads/attached/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;  
    } 

    public function searchTicket(Request $request)
    {
        $admin_access = $this->get_current_admin_access();
        $tickets = Ticket::with("user")->with("ticket_status")->where('subject', 'like', '%'.$request->searchVal.'%')->where('user_email', 'like', '%'.$request->searchVal.'%')->orWhere('number', 'like', '%'.$request->searchVal.'%')->orWhere('description', 'like', '%'.$request->searchVal.'%')->get();
        if(isset($admin_access['read_ticket'])) {
            return response()->json($tickets);
        } else {
            return response()->json(array());
        }
    }
}
