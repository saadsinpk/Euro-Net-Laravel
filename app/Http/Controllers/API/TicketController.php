<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Category;
use App\Models\RepairPayment;
use App\Models\Ticket;
use App\Models\Ticket_status;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Resources\UserResource as UserResource;
use Laravel\Passport\Token;

class TicketController extends BaseController
{
    public function index()
    {

        $tickets = Ticket::with("user")->with("category")->orderBy("created_at", "DESC")->get();
        if (count($tickets) > 0) {
            $success['tickets'] = $tickets;
            return $this->sendResponse($success, 'tickets');
        } else {
            $success['tickets'] = 'data not';
            return $this->sendResponse($success, 'found');
        }
    }

    public function show($id)
    {
        $ticket = Ticket::with("user")->with("ticket_status")->with("category")->with("reply")->where("id", $id)->where("show_ticket", '1')->first();
        if ($ticket) {
            $ticket_status = Ticket_status::all();
            $ticket->ischecked = 1;
            $ticket->save();
            $success['ticket'] = $ticket;
            return $this->sendResponse($success, 'found');
        } else {
            $success['tickets'] = 'data not';
            return $this->sendResponse($success, 'found');
        }
    }

    public function destroy($id)
    {
        $ticket = Ticket::where("id", $id)->delete();
        if ($ticket) {
            $success['ticket'] = 'deleted';
            return $this->sendResponse($success, 'successfully');
        } else {
            $success['tickets'] = 'not';
            return $this->sendResponse($success, 'found');
        }
    }

    public function updateStatus($id, $status, Request $request)
    {
//        $access_token = $request->header('Authorization');
//        $auth_header = explode(' ', $access_token);
//       return $token = $auth_header[1];

//        return auth()->user()->id;
        $ticket = Ticket::where("id", "=", $id)->first();
        if ($ticket) {
            $ticket_status = Ticket_status::where("id", "=", $status)->first();
            $message = 'Ticket Status update Ticket ID:"' . $ticket->number . '" to:"' . $ticket_status->option . '" from IP:' . \Request::ip() . ' at ' . date("F j, Y, g:i a");
//            AdminLog::create(["admin_id" => auth()->user()->id, "message" => $message, "status" => "warning"]);

            $ticket->status = $status;
            $ticket->save();

            $success['ticket'] = $message;
            return $this->sendResponse($success, 'updated');

        } else {

            $success['tickets'] = 'not';
            return $this->sendResponse($success, 'found');
        }

    }

    public function store(Request $request)
    {
        $ticket = new Ticket;
        if($request->name) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|unique:users',
            ]);

            if ($validator->fails()) {
                return  response()->json(['errors'=>$validator->errors()], 422);
            }

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);

            if(auth()->user()) {
                $user->verify = 1;
            } else {
                $user->verify = 2;
            }
            $verify_token = base64_encode(date("mdY").rand(10,100000));
            $verify_token = urlencode($verify_token);
            $user->verify_token = $verify_token;

            $user->assignRole('user');

            $user->save();
        }

        $ticket->subject = $request->subject;
        $ticket->category_id = $request->category_id;
        $ticket->description = $request->description;

        $ticket->status = 1;


            $ticket->show_ticket = 2;

        $ticket->flag = 1;
        $tickets = Ticket::get();
        $random_key = $tickets->count() + 1;

        $category = Category::find($request->category_id);

        if($request->category_id == 5) {
            $category->name = "EUR";
        }

        $ticket->number = strtoupper(substr($category->name, 0, 3)) . '-' . date("mdY") . str_pad($random_key, 2, "0", STR_PAD_LEFT);

        if($request->file_name) {
            $ticket->file_name = implode(",", $request->file_name);
        }
        $ticket->selected_lang = app()->getLocale();
        $ticket->save();

        $success['ticket'] = $ticket;
        return $this->sendResponse($success, 'successfully');

    }

    public function ticketHistory(Request $request)
    {
            $tickets = Ticket::orderBy("last_admin_reply_date", "DESC")->with("ticket_status")->where("user_id", "=", $request->user_id)->get();

        $success['ticket'] = $tickets;
        return $this->sendResponse($success, 'successfully');

    }
    public function indexreply(Request $request)
    {
//        if($request->admin_id) {
            $tickets = Ticket::with("user")->with("category")->where("status", '3')->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->get();
            foreach ($tickets->toArray() as $key => $ticket) {
                if (is_array($ticket['user']) > 0) {
                } else {
                    unset($tickets[$key]);
                }
            }
            $rPayment = RepairPayment::orderBy('id', 'desc')->get();

            $success['ticket'] = $tickets;
            $success1['ticket'] = $rPayment;
            return $this->sendResponse($success, $success1);
//        }
    }
    public function userindexreply(Request $request)
    {
        if($request->user_id) {
            $tickets = Ticket::with("user")->with("category")->where("status", '3')->where("show_ticket", '1')->orderBy("ischecked", "ASC", "created_at", "DESC")->where('user_id', $request->user_id)->get();
            foreach ($tickets->toArray() as $key => $ticket) {
                if (is_array($ticket['user']) > 0) {
                } else {
                    unset($tickets[$key]);
                }
            }
            $rPayment = RepairPayment::orderBy('id', 'desc')->where('user_id', $request->user_id)->get();

            $success['ticket'] = $tickets;
            $success1['ticket'] = $rPayment;
            return $this->sendResponse($success, $success1);
        }
    }
}
