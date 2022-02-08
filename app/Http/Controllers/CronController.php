<?php

namespace App\Http\Controllers;

  
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tracking;

class CronController extends Controller
{
    //

    public function index()
    {
        $Users = User::where("verify", "=", "2")->get();
        foreach ($Users as $user_key => $User) {
            $time_to_check = strtotime('+3 days', strtotime($User->last_verify_mail));
            if(time() >= $time_to_check) {
                $mailData = [
                    'title' => trans('email.user_verify_mail_to_user_title'),
                    'description' => trans('email.user_verify_mail_to_user_description'),
                    'button' => trans('email.user_verify_mail_to_user_button'),
                    'url' => 'http://euronetsupport.com/login/'.$User->verify_token.'/'
                ];
                Mail::to($User->email)->send(new EmailTicket($mailData));
                AdminLog::create(["admin_id"=>auth()->user()->id,"message"=>$message,"status"=>"success"]);
                Tracking::create(["email"=>$User->email,"button"=>trans('email.user_verify_mail_to_user_button'),"description"=> trans('email.user_verify_mail_to_user_description'),"title"=>trans('email.user_verify_mail_to_user_title')]);
            }
        }
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".gz";
  
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() . "/app/backup/" . $filename;
  
        $returnVar = NULL;
        $output  = NULL;
  
        exec($command, $output, $returnVar);
    }

}
