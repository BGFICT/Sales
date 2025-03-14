<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PayController; 
use Omnipay\Omnipay; 

class PaypalController extends Controller
{
    private $gateway;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function _construct()
    {
      // $this->middleware('auth');
      $this->gateway = Omnipay::create('PayPal_Rest');
      $this->gateway->setClientId(env('PAYPAL_LIVE_CLIENT_ID'));
      $this->gateway->setSecret(env('PAYPAL_LIVE_CLIENT_SECRET'));
      $this->gateway->setTestMode(false);  // Use true for sandbox mode 
    }
    public function pay(Request $request){
        try{
             $response = $this->gateway->purchase(array(
                'amount' => $request->amount, 
                'currency' => env('PayPAL_Currency'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error'),
             ));
             if($response){
                $response->redirect();
             }else{
                return $request->getMessage(); 
             }
       }catch(\Throwable $th){
            return $th->getMessage();

       }
    }
}
