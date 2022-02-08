<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\AdminFeature;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get_current_admin_access()
    {
        if(isset(auth()->user()->id)) {
            $MyAdminFeature = AdminFeature::where("admin_id", "=", auth()->user()->id)->get();
            $my_admin_features = array();
            foreach ($MyAdminFeature as $key => $value) {
                $my_admin_features[$value->feature] = $value->value;
            }
            return $my_admin_features;
        }
    }
}
