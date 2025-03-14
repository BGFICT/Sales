<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpesa;

class PayController extends Controller
{
    // Display a form for making a payment
    // this is through mpesa
    public function showPaymentForm()
    {
$BusinessShortCode= '174379';
$LipaNaMpesaPassKey= '';
$TransactionType= 'CustomerPayBillOnline';
            $Amount= '1';
            $PartyA= '254714572978';
            $PartyB= '174379';
            $PhoneNumber= '254714572978';
            $CallBackURL= '';
            $AccountReference= 'AccountReference';
            $TransactionDesc= 'TransactionDesc';
            $Remarks= 'Remarks';

        $mpesa=new \Safaricom\Mpesa\Mpesa();


        $stkPushSimulation=$mpesa->STKPushSimulation(
           $BusinessShortCode,
           $LipaNaMpesaPassKey,
           $TransactionType,
           $Amount,
           $PartyA,
           $PartyB,
           $PhoneNumber,
           $CallBackURL,
           $AccountReference,
           $TransactionDesc,
           $Remarks
        );
        // return view('payments.form');
    }

    // Handle the payment processing
    public function processPayment(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            // Add other validation rules as needed
        ]);

        // Process the payment (example logic)
        // You would typically call a payment gateway's API here

        // Assuming payment was successful
        return redirect()->route('payment.success');
    }

    // Show a success page after payment
    public function paymentSuccess()
    {
        return view('payments.success');
    }
}
