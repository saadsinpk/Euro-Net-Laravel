<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminFeature;
use App\Models\AdminLog;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\API\BaseController as BaseController;
class AdminController extends BaseController
{
    public function log($id)
    {

            $logs_array = AdminLog::where("admin_id", "=", $id)->orderBy('created_at', 'desc')->limit(100)->get();
            $total_logs = $logs_array->count();

        $success['data'] = $logs_array;
        return $this->sendResponse($success, 'successfully');
    }
    public function features(Request $request, $id) {
            $AdminFeature = AdminFeature::where("admin_id", "=", $id)->get();
            $return_features = array();
            foreach ($AdminFeature as $key => $value) {
                $return_features[$value->feature] = $value->value;
            }

        $success['data'] = $AdminFeature;
        return $this->sendResponse($success, 'successfully');
    }
    public function postfeatures(Request $request, $id) {

                AdminFeature::where("admin_id", "=", $id)->delete();
                foreach ($_POST as $key => $value) {
                    if($key != '_token' AND $key != 'submit') {
                        $AdminFeature = new AdminFeature();
                        $AdminFeature->admin_id = $id;
                        $AdminFeature->feature = $key;
                        $AdminFeature->value = $value;
                        $AdminFeature->save();
                    }
                }
            $AdminFeature = AdminFeature::where("admin_id", "=", $id)->get();
            $return_features = array();
            foreach ($AdminFeature as $key => $value) {
                $return_features[$value->feature] = $value->value;
            }

            $user = User::find($id);

            $message = 'Update Admin Features "'.$user->name.' ('.$user->email.')" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");


        $success['data'] = $message;
        return $this->sendResponse($success, 'successfully');

    }
    public function destroy ($id, Request $request) {
            $user = User::find($id);
            $message = 'Delete Admin "'.$user->name.' ('.$user->email.')" from IP:'.\Request::ip().' at '.date("F j, Y, g:i a");
//            AdminLog::create(["admin_id"=>$request->admin_id,"message"=>$message,"status"=>"danger"]);

            $user->syncRoles('admin');

            if($user->avatar) {
                $path = public_path('uploads/avatar/'.$user->avatar.'');
                unlink($path);
            }


            $user->delete();
if ($message) {
    $success['data'] = $message;
    return $this->sendResponse($success, 'successfully');
}
else{

    $success['data'] = 'data';
    return $this->sendResponse($success, 'not found!');
}

    }
    public function destroyRows(Request $request) {
//        if($request->admin_id) {
            $users = User::whereIn("id", explode(",", $request->ids))->get();
            foreach ($users as $user) {
                $message = 'Delete Admin "' . $user->name . ' (' . $user->email . ')" from IP:' . \Request::ip() . ' at ' . date("F j, Y, g:i a");
//                AdminLog::create(["admin_id" => $request->admin_id, "message" => $message, "status" => "danger"]);

                User::where("id", explode(",", $user->id))->delete();
            }
            $success['data'] = $users;
            return $this->sendResponse($success, 'deleted successfully');
        }
//    }
}
