<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with PayPal</title>
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="" rel="stylesheet" />
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" ">
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
    ></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap");

      body {
        /* background-color: #0b4add; */
        font-family: "Rubik", sans-serif;
      }

      .card {
        width: 400px;
        border: none;
        border-radius: 15px;
      }
      a {
        /* width: 330px;
        border: none;  */
        background: #f3f4f6;
        border-radius: 15px;
      }
     

      .justify-content-around div {
        border: none;
        border-radius: 30px;
        background: #f6f6f3;
        padding: 5px 20px 5px;
        color: #8d9297;
      }

      .justify-content-around span {
        font-size: 12px;
        background: #003087;
      }

      .justify-content-around div:hover {
        background: #545ebd;
        color: #fff;
        cursor: pointer;
      }

      .justify-content-around div:nth-child(1) {
        /* background: #545ebd; */
        color: #fff;
      }

      span.mt-0 {
        color: #2e4a66;
        font-size: 12px;
      }

      h6 {
        font-size: 15px;
      }
      .mpesa {
        background-color: rgb(101, 112, 128) !important;
      }
      .strip {
        background-color: rgb(207, 214, 221) !important;
      }
      .cards {
        background-color: rgb(208, 230, 11) !important;
      }.card {
        /* background-color: rgba(3, 44, 63, 0.952) !important; */
        background-color: #009cde; 
      }

      img {
        border-radius: 15px;
      }
    </style>
  </head>
  <body oncontextmenu="return false" class="snippet-body">
    <div class="container d-flex justify-content-center">
      <div class="card mt-5 px-3 py-4">
        <div class="d-flex flex-row justify-content-around">
          <span>
              <a href="{{ url('mpesa',$total_amount) }}" class="btn btn-danger">MPesa</a>        
        </span>
          
            <span>
              <a href=" " class="btn btn-danger">Pay Pal</a>            
            </span> 
       
         <span>
            <a href="{{ url('stripe',$total_amount)}}" class="btn btn-danger">Credit Card </a>
         </span> 

         <span>
          <a href="{{ url('cash_oder',$total_amount) }}" class="btn btn-danger">Cash  </a>
       </span> 
        

        </div>
        <div class="media mt-4 pl-2">
            <img src="{{ asset('images/paypal.png') }}" alt="M-PESA Logo" class="mr-3" height="75" />
          <div class="media-body">
            <h6 class="mt-1">PAY USING PAYPAL</h6>

          </div>
        </div>
        <div class="media mt-3 pl-2">
                          <!--bs5 input-->

            <form class="row g-3" action="./stk_initiate.php" method="POST">
              {{-- action="{{ route('payment') }}"  --}}

              @csrf

                <div class="col-12">
                  {{-- <label for="inputAddress"  class="btn btn-success">Pay Now ${{ $total_amount }}</label> --}}
            {{-- <p class="btn btn-primary btn-lg btn-block" type="submit">Pay Now {{ $total_amount }}</p> --}}
                  <input type="text" style="display:none;" class="form-control" name="amount" placeholder="Enter Amount" value="{{ $total_amount }}"> 

            
                <div class="col-12">
                  {{-- <label for="inputAddress"  class="btn btn-success">Pay Now ${{ $total_amount }}</label> --}}
            {{-- <p class="btn btn-primary btn-lg btn-block" type="submit">Pay Now {{ $total_amount }}</p> --}}
                  {{-- <input type="text" class="form-control" name="amount" placeholder="Enter Amount"> --}}

                  <p>CLick pay to go to your paypal account.</p>
                </div>
                {{-- <div class="col-12">
                  <label for="inputAddress2" class="form-label" >Enter Phone Number</label>
                  <input type="text" class="form-control" name="phone"  placeholder="Enter Phone Number">
                </div> --}}
             
                <div class="col-12">
                  <form action="{{ route('payment') }}" method="post">

                    @csrf

                    <input type="hidden" name="amount" value="{{ $total_amount}}">


                     <button type="submit" class="btn btn-success"  id="order_total_price" data-price="{{ $total_amount }}" name="submit" value="submit" wire:click="checkout">Pay ${{ $total_amount}}</button>
                
                   </form>
                </div>
              </form>
              <!--bs5 input-->
          </div>
        </div>
      </div>
    </div>
    <script
      type="text/javascript"
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
    ></script>
    <script type="text/javascript" src=""></script>
    <script type="text/javascript" src="../public/js/currency.js"></script>
    <script type="text/Javascript"></script>
    <script>
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
  </body>
</html>