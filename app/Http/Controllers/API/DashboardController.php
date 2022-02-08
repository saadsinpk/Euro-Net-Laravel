<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BitMain;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
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


        $success1['data'] = $categories;
        $success2['data'] = $tickets_reply;
        $success3['data'] = $tickets_opening;
        $success4['data'] = $tickets_processing;
        $success5['data'] = $tickets_pending;
        $success6['data'] = $tickets_complete;
        $success7['data'] = $users;

        $success8['data'] = $bitmain;
//        $success['data'] = $bitmain.'categories'.$categories.'tickets_reply'.$tickets_reply.'users'.$users.'tickets_complete'.$tickets_complete.'tickets_opening'.$tickets_opening.'tickets_pending'.$tickets_pending.'tickets_complete'.$tickets_complete;
        return $this->sendResponsedashboard($success1, $success2,$success3, $success4,$success5, $success6,$success7, $success8,'successfully');

    }
}
