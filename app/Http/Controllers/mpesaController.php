<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;
use Mpesa; 


class mpesaController extends Controller
{
    // public function stkSimulation(){
    //     $mpesa= new \safaricom\Mpesa\Mpesa();
    //     $stkPushSimulation=$mpesa->STKPushSimulation($BusinessShortCode, $LipaNaMpesaPasskey, 
    //     $TransictionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference,
    //     $TransactionDesc, $Remarks);
    // }
    public function lipaNaMpesaPassword(){
        //timestamp
        $timestamp = Carbon::rawParse('now')->format('YmdHms');
        //passkey
        $passKey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        //businessShortcode
        $businessShortCode = 174379;
        //generate password. 
        $mpesaPassword = base64_encode($businessShortCode.$passKey.$timestamp);

        return $mpesaPassword;
    }

   public Function newAccessToken(){
    $consumer_key="KbIs52GlIVwe61b5mTWqARzYGyG7dDRoRwi2961iqhqczpO9";
    $consumer_secret="B37NXerCt7S4xO37ASIgPUFjYaT3mwRkGnTvnTqfeyI2KGZGQTikQYzknEpjMAUn";
    $credentials = base64_encode($consumer_key. ":" . $consumer_secret);
    $url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials,"Content-Type:application/json"));
    curl_setopt($curl, CURLOPT_HEADER,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl); 
    $access_token = json_decode($curl_response); 
    curl_close($curl);

    return $access_token->access_token; 

   }

   public function stkpush(){
     
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $curl_post_data = [

        // 'BusinessShortCode' => 174379,
        // // paybill (888300) A/C (MITI)
        // 'Password' => $this->lipaNaMpesaPassword(), 
        // 'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
        //  'TransactionType' => 'CustomerPayBillOnline',
        //  'Amount' => '6000',
        //  'PartyA' => '254714572978',
        //  'PartyB' => 174379,
        // //  business short code {paybill (888300) A/C (MITI)}
        //  'PhoneNumber'=> '254714572978',
        //  'CallBackURL' => 'https://www.betterglobeforestry.com/',
        //  'AccountReference' => "Better-Globe-Forestry Miti Magazine",
        //  'TransactionDesc' => "Subcription to $59"

        
            'BusinessShortCode'=> 174379,
            'Password'=> "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjQwNDI0MDg0NTU2",
            'Timestamp'=> "20240424084556",
            'TransactionType'=> "CustomerPayBillOnline",
            'Amount'=> 1000,
            'PartyA'=> 254714572978, //where it will go
            'PartyB'=> 174379,  
            'PhoneNumber'=> 254714572978,  //the number that is paying 
            'CallBackURL'=> "https://miti-magazine.betterglobeforestry.com/stk/push/callback/url",
            'AccountReference'=> "CompanyXLTD",
            'TransactionDesc'=> "Subscription "    

    ];

    $data_string = json_encode($curl_post_data);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->newAccessToken()));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
     
    // $curl_response = curl_exec($curl)
    // return $curl_response;

    if($curl_response = curl_exec($curl)){
        return $curl_response; 
    }

     return "Stkpush FAILED!";

   }
   public function MpesaRes(Request $request){

   }
    
}
