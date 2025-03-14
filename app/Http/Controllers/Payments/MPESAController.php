<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MPESAController extends Controller
{
    public function getAccessToken(){
        $url = env('MPESA_ENV') = 0
        ? ''
        : ''; 

        $curl = curl_init($url);
        curl_setopt_array(
            $curl,
            array(
                  CURLOPT_HTTPHEADER => ['Content-Type: application/json; charste=utf8'],
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_HEADER => false, 
                  CURLOPT_USERPWD => env('MPESA_CONSUMER_KEY') . ';' . env('MPESA_CONSUMER_SECRET')
                )
            );
            $response = json_decode(curl_exec($curl));
            curl_close($curl);

            return $response; 
    }
}
