<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Instamojo\Instamojo;

class PaymentController extends Controller
{
    
    public function createInstaMojoPayment(Request $request){
        $api = new \Instamojo\Instamojo(
            "test_d883b3a8d2bc1adc7a535506713",
            "test_dc229039d2232a260a2df3f7502",
            "https://test.instamojo.com/api/1.1/"
        );
 
        try {
            $response = $api->paymentRequestCreate(array(
                "purpose" => "FIFA 16",
                "amount" => $request->amount,
                "buyer_name" => $request->name,
                "send_email" => true,
                "email" => $request->email,
                "phone" => $request->mobile_number,
                "redirect_url" => "http://127.0.0.1:8000/pay-success"
                ));
                 
                header('Location: ' . $response['longurl']);
                exit();
        }catch (Exception $e) {
            print('Error: ' . $e->getMessage());
        }
    }
    
    public function paymentSuccess(Request $request)
    {
        return view('payment.success');
    }
}
