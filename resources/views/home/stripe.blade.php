<!DOCTYPE html>
<html>
<head>
    <title>Sales-Page Payment </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      
</head>
<body>
    {{-- <div class="hero_area">
        <span>@include('frontend.layouts.header')</span>

    </div> --}}
<div class="container">

    <div class="d-flex flex-row justify-content-around">
        <div class="mpesa"><h1>Credit Card / Debit Card </h1></div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                        <h3 class="panel-title" >Payment Details</h3>
                </div>

                <div class="single-widget payement">
                    <div class="content">
            <img src="{{ asset('images/card.png') }}" alt="M-PESA Logo" class="mr-3" height="75" />

                        {{-- <img src="{{('backend/img/payment-method.png')}}" alt="#"> --}}
                    </div>
                </div>
                

                <div class="panel-body">
    
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
    
                    <form 
                            role="form" 
                            action="{{ route('stripe.post', $total_amount) }} " 
                            method="post" 
                            class="require-validation"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                        @csrf
    
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input
                                    class='form-control' size='4' type='text' placeholder='ex. Edwin Joshua'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> 
                                <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text' placeholder='ex. 4242 4242 4242 4242'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="{{ 'index' }} " class="btn mt-5 bg">
                                <button class="btn btn-primary btn-lg btn-block" type="submit" id="order_total_price" data-price="{{ $total_amount }}">Pay Now {{ $total_amount }}</button></a>
                            </div>
                        </div>
                            
                    </form>
                </div>
            </div>        
        </div>
    </div>
        
</div>
    
</body>
    
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    
<script type="text/javascript">
  
$(function() {
  
    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/
    
    var $form = $(".require-validation");
     
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');
    
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
     
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }
    
    });
      
    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
                 
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
     
});
    function updatePrices() {
    if (typeof localStorage !== "undefined") {
        const currencyCode = localStorage.getItem("currencyCode");
        const exchangeRate = localStorage.getItem("currentExchange");

        if (!currencyCode || !exchangeRate) return; // Exit if data is missing

        const rate = parseFloat(exchangeRate); // Convert to float

        document.querySelectorAll("#order_total_price, #order_total_price1 ").forEach(element => {
            let basePrice = parseFloat(element.getAttribute("data-price")); 
            if (!isNaN(basePrice)) {
                let convertedPrice = basePrice * rate; 
                element.textContent = `${currencyCode} ${Math.ceil(convertedPrice)}`;
                {{}}
                order_total_price1.value=`${Math.ceil(convertedPrice)}`;// round up since daraa only accepts integers
            }
        });

    } else {
        console.error("localStorage is not available.");
    }
    }
    document.addEventListener("DOMContentLoaded", function () {
        
        if (localStorage.currencyCode && localStorage.currentExchange) {
            updatePrices();
        }
    });

    
</script>
</html>