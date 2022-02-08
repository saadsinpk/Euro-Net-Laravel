<?php
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Session;
use App\Models\PaymentRequest;
use App\Models\RepairPayment;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailTicket;
use picqer\Barcode;
 
class LabelController extends Controller
{
    public function __construct()
    { }
 
    public function download($number)
    {
        if(Auth::user()) {
            $RepairPayment = RepairPayment::with("user")->where("number", "=", $number)->first();
            if(!empty($RepairPayment)) {
                if(Auth::user()->id == $RepairPayment->user->id || Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('admin')) {
                    \QrCode::size(500)
                        ->format('png')
                        ->generate(url('/user/repair_payment/view/'.$RepairPayment->id), public_path('uploads/attached/qrcode_'.$RepairPayment->id.'.png'));
                    // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                    // $generatorPNG = new BarcodeGeneratorPNG();
                    // echo '<img src="data:image/png;base64,'.base64_encode($generatorPNG->getBarcode('000005263635', $generatorPNG::TYPE_CODE_128)).'">';

                    // exit();


                    return view("barcode", compact("RepairPayment"));
                }
            }
        }
        return response()->json(['message' => 'Page not found.'], 404);
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML($html);
        // return $pdf->stream();
        // return $pdf->download('repair_.pdf');
        // echo "<pre>";
        //     print_r($RepairPayment->toArray());
        // echo "</pre>";
    }
}