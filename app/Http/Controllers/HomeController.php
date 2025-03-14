<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\PostComment;
use App\Models\Purchase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Rules\MatchOldPassword;
use Hash;
use Helper;
use Illuminate\Contracts\Session\Session as SessionSession;

use Session;
use Stripe;

class HomeController extends Controller
{

    private $gateway;
    /**
     * Create a new controller instance.
     *
     * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->gateway = Omnipay::create('PayPal_Rest');
    //     $this->gateway->setClientId(env('PAYPAL_LIVE_CLIENT_ID'));
    //     $this->gateway->setSecretId(env('PAYPAL_LIVE_CLIENT_SECRET'));
    //     $this->gateway->setTestMode(false);

    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(){
        return view('user.index');
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('user.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        // return $request->all();
        $user=User::findOrFail($id);
        $data=$request->all();
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
        }
        return redirect()->back();
    }

    // Order
    public function orderIndex(){
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders',$orders);
    } 
    
    public function mpesaorderIndex(){
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.mpesa_orders.index')->with('orders',$orders);
    }
    public function userOrderDelete($id)
    {
        $order=Order::find($id);
        if($order){
           if($order->status=="process" || $order->status=='delivered' || $order->status=='cancel'){
                return redirect()->back()->with('error','You can not delete this order now');
           }
           else{
                $status=$order->delete();
                if($status){
                    request()->session()->flash('success','Order Successfully deleted');
                }
                else{
                    request()->session()->flash('error','Order can not deleted');
                }
                return redirect()->route('user.order.index');
                return redirect()->route('user.mpesa_orders.index');
           }
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderShow($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('user.order.show')->with('order',$order);
    }
    public function mpesaorderShow($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('user.mpesaorder.mpesa')->with('order',$order);
    }
    // Product Review
    public function productReviewIndex(){
        $reviews=ProductReview::getAllUserReview();
        return view('user.review.index')->with('reviews',$reviews);
    }
    
    public function productReviewEdit($id)
    {
        $review=ProductReview::find($id);
        // return $review;
        return view('user.review.edit')->with('review',$review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewUpdate(Request $request, $id)
    {
        $review=ProductReview::find($id);
        if($review){
            $data=$request->all();
            $status=$review->fill($data)->update();
            if($status){
                request()->session()->flash('success','Review Successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
        }
        else{
            request()->session()->flash('error','Review not found!!');
        }

        return redirect()->route('user.productreview.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewDelete($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted review');
        }
        else{
            request()->session()->flash('error','Something went wrong! Try again');
        }
        return redirect()->route('user.productreview.index');
    }

    public function userComment()
    {
        $comments=PostComment::getAllUserComments();
        return view('user.comment.index')->with('comments',$comments);
    }
    public function userCommentDelete($id){
        $comment=PostComment::find($id);
        if($comment){
            $status=$comment->delete();
            if($status){
                request()->session()->flash('success','Post Comment successfully deleted');
            }
            else{
                request()->session()->flash('error','Error occurred please try again');
            }
            return back();
        }
        else{
            request()->session()->flash('error','Post Comment not found');
            return redirect()->back();
        }
    }
    public function userCommentEdit($id)
    {
        $comments=PostComment::find($id);
        if($comments){
            return view('user.comment.edit')->with('comment',$comments);
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userCommentUpdate(Request $request, $id)
    {
        $comment=PostComment::find($id);
        if($comment){
            $data=$request->all();
            // return $data;
            $status=$comment->fill($data)->update();
            if($status){
                request()->session()->flash('success','Comment successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
            return redirect()->route('user.post-comment.index');
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }

    }

    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('user')->with('success','Password successfully changed');
    }
// card, visa
    public function stripe($total_amount){

        return view('home.stripe',compact('total_amount'));
    }
    public function stripePost(Request $request,$total_amount)
    {
        dd($total_amount);
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" =>$total_amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thank you for your Payment to Sales-Page Application(powered by BGF)." 
        ]);
         Session::flash('success', 'Payment successful!');
              
        return back();
    }


    // mpesa
    public function mpesa($total_amount){

        return view('home.mpesa',compact('total_amount'));
    }
    public function mpesaPost(Request $request,$total_amount)
    {
        dd($total_amount);
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" =>$total_amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thank you for your Payment to Sales-Page Application(powered by BGF)." 
        ]);
         Session::flash('success', 'Payment successful!');
              
        return back();
    }



 
    // paypal
    public function paypal($total_amount){

        return view('home.paypal',compact('total_amount'));
    }
    public function paypalPost(Request $request,$total_amount)
    {
    //    try{
    //         $response = $this->gateway->purchase(array(
    //             'total_amount' => $request->total_amount,
    //             'currency' => env('PAYPAL_CURRENCY'),
    //             'returnUrl' => url('Success'),
    //             'cancelUrl' => url('Failed'),
    //         ))->send();

    //         if ($response->isRedirect()){
    //             $response->redirect();
    //         }else{
    //             return $response->getMessage();
    //         }
    //    }catch (\Throwable $th){
    //        return $th->getMessage();
    //    }
    }

    // cash oder
    public function cash_oder($total_amount){

        return view('home.cash_oder',compact('total_amount'));
    }
    public function cash_oderPost(Request $request,$total_amount)
    {
        dd($total_amount);
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" =>$total_amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thank you for your Payment to Sales-Page Application(powered by BGF)." 
        ]);
         Session::flash('success', 'Payment successful!');
              
        return back();
    }



    //home controller
    public function initiatePayment(Request $request)
    {
        // Example Order Details
        $orderId = '12345'; // Unique order ID
        $amount = 1; // Amount in KES
        $phoneNumber = '254717606015'; // Customer's phone number
        $email = 'mwangimike15@gmail.com'; // Customer's email

        // Load iPay Credentials from Environment
        $vendorId = env('IPAY_VENDOR_ID');
        $callbackUrl = env('IPAY_CALLBACK_URL');
        $secretKey = env('IPAY_VENDOR_SECRET');
        $paymentUrl = env('IPAY_PAYMENT_URL');

        // Prepare POST Data
        $postData = [
            'live' => '1', // Test environment (set to '1' for live)
            'oid' => $orderId, // Order ID
            'inv' => 'INV_' . $orderId, // Invoice number
            'ttl' => $amount, // Amount
            'tel' => $phoneNumber, // Customer's phone number
            'eml' => $email, // Customer's email
            'vid' => $vendorId, // Vendor ID
            'curr' => 'KES', // Currency
            'p1' => '',
            'p2' => '',
            'p3' => '',
            'p4' => '',
            'cbk' => $callbackUrl, // Callback URL
            'cst' => '1', // Customer confirmation required
            'crl' => '2', // Redirect URL
        ];

        // Generate the Hash
        $hashString = $postData['live'].$postData['oid'] . $postData['inv'] . $postData['ttl'] . $postData['tel'] . $postData['eml'] . $postData['vid'];
        $postData['hsh'] = hash_hmac('sha256', $hashString, $secretKey);

        // Redirect to iPay Payment Page
        return view('ipay/ipay', [
            'paymentUrl' => $paymentUrl,
            'data' => $postData,
        ]);
    }

    public function handlePaymentCallback(Request $request)
    {

        $profile=Auth()->user();


        if (!$profile) {
            return response()->json(['error' => "user not logged in"], 401);
        }
        // Retrieve and process callback data from iPay
        $status = $request->get('status');
        $transactionId = $request->get('txncd');
        $orderId = $request->get('id');
        $amount = $request->get('mc');
        $name = $request->get('msisdn_id');
        $email=$profile->email;
        $phone=$request->get('msisdn_idnum');
    
        if ($status === 'aei7p7yrx4ae34') {
            // Handle successful payment
             $this->updateOrdersOnSuccess($orderId, $transactionId, $amount, $name, $email, $phone, $profile);
            // return response()->json(['message' => 'Payment successful!', 'transaction_id' => $transactionId, 'data' => $request->all()]);
        } else {
            // Handle failed payment
            return response()->json(['message' => 'Payment failed!', 'status' => $status]);
        }
    }
   
}
