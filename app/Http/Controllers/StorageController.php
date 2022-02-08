<?php

namespace App\Http\Controllers;

  
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class StorageController extends Controller
{
    //

    public function index()
    {
    }
    public function blockbackup($filename) {
    	if(Auth::user()) {
		    $path = public_path() . '/uploads/attached/' . $filename;
		    if(!File::exists($path)) {
		        return response()->json(['message' => 'Image not found.'], 404);
		    }

		    $file = File::get($path);
		    $type = File::mimeType($path);

		    $response = Response::make($file, 200);
		    $response->header("Content-Type", $type);

		    return $response;
	    } else {
	        return response()->json(['message' => 'Image not found.'], 404);
	    }
    }

}
