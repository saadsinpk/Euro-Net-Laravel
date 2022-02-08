<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class TicketController extends BaseController
{
    public function category()
    {
        $categories = Category::all();
        $success['cats'] = $categories;
        return $this->sendResponse($success, 'successfully');
    }

    public function ticketDetail($id, Request $request)
    {
        if ($request->user_id) {
            $ticket = Ticket::with("category")->with("reply")->where("id", "=", $id)->where("user_id", "=", $request->user_id)->first();

            $success['data'] = $ticket;
            return $this->sendResponse($success, 'successfully');
        }
    }

}
