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
        $users = User::role('user')->where("verify", "=", "1")->get();
        $categories = Category::all();
        $tickets_new = Ticket::where("status", "=", "1")->where("show_ticket", "=", "1")->get();
        $tickets_new = $tickets_new->count();
        $tickets_opening = Ticket::where("status", "=", "2")->where("show_ticket", "=", "1")->get();
        $tickets_opening = $tickets_opening->count();
        $tickets_reply = Ticket::where("status", "=", "3")->where("show_ticket", "=", "1")->get();
        $tickets_reply = $tickets_reply->count();
        $tickets_processing = Ticket::where("status", "=", "6")->where("show_ticket", "=", "1")->get();
        $tickets_processing = $tickets_processing->count();
        $tickets_pending = Ticket::where("status", "=", "4")->where("show_ticket", "=", "1")->get();
        $tickets_pending = $tickets_pending->count();
        $tickets_complete = Ticket::where("status", "=", "5")->where("show_ticket", "=", "1")->get();
        $tickets_complete = $tickets_complete->count();
        $bitmain = BitMain::all();
        if(auth()->user()) {
            if(auth()->user()->hasRole("admin")) {
                return view("dashboard", compact("users", "tickets_new", "tickets_opening", "tickets_reply", "tickets_processing", "tickets_pending", "tickets_complete"));
            }else {
                return view("user.ticket", compact("categories", "bitmain"));
            }
        }else {
            return view("user.ticket", compact("categories", "bitmain"));
        }
    }

    public function fileUpload(Request $request)
    {   
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
        $tickets = Ticket::with("user")->with("ticket_status")->where('subject', 'like', '%'.$request->searchVal.'%')->where('user_email', 'like', '%'.$request->searchVal.'%')->orWhere('number', 'like', '%'.$request->searchVal.'%')->orWhere('description', 'like', '%'.$request->searchVal.'%')->get();
        return response()->json($tickets);
    }
}
