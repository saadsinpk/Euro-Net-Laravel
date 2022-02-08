<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    public function sendResponsedashboard($success1, $success2,$success3, $success4,$success5, $success6,$success7, $success8 ,$message)
    {
        $response = [
            'success' => true,
            'data'    => $success1,
            'data1'    => $success2,
            'data2'    => $success3,
            'data3'    => $success4,
            'data4'    => $success5,
            'data5'    => $success6,
            'data6'    => $success7,
            'data7'    => $success8,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}