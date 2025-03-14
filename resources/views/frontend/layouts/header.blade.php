<header class="header shop">
    <!-- Topbar -->
    <div class="topbar" style="background: #6fae2d ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                                $settings=DB::table('settings')->get();
                                
                            @endphp
                            <li>
                                <i class="ti-headphone-alt" style="color: rgb(243, 243, 243)"></i> 
                                <a href="tel:@foreach($settings as $data){{$data->phone}}@endforeach">
                                    @foreach($settings as $data){{$data->phone}}@endforeach
                                </a>
                            </li>
                            
                            <li>
                                <i class="ti-email" style="color: rgb(243, 243, 243)"></i> 
                                <a href="mailto:@foreach($settings as $data){{$data->email}}@endforeach">
                                    @foreach($settings as $data){{$data->email}}@endforeach
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                        <li><i class="ti-location-pin" style="color: rgb(243, 243, 243)"></i> <a href="{{route('order.track')}}">Track Order</a></li>
                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li> --}}
                            @auth 
                                @if(Auth::user()->role=='admin')
                                    <li><i class="ti-user"  style="color: rgb(243, 243, 243)"></i> <a href="{{route('admin')}}"  target="_blank">Dashboard</a></li>
                                @else 
                                    <li><i class="ti-user"  style="color: rgb(243, 243, 243)"></i> <a href="{{route('user')}}"  target="_blank">Dashboard</a></li>
                                @endif
                                <li><i class="ti-power-off" style="color: rgb(243, 243, 243)"></i> <a href="{{route('user.logout')}}">Logout</a></li>

                            @else
                                <li><i class="ti-power-off" style="color: rgb(243, 243, 243)"></i><a href="{{route('login.form')}}">Login /</a> <a href="{{route('register.form')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        @php
                            $settings=DB::table('settings')->get();
                        @endphp                    
                        <a href="{{route('home')}}"><img src="{{asset('backend/img/logo.png')}}" alt="logo"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option >All Category</option>
                                @foreach(Helper::getAllCategory() as $cat)
                                    <option>{{$cat->title}}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="{{route('product.search')}}">
                                @csrf
                                <input name="search" placeholder="Search Products Here....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar shopping">
                            @php 
                                $total_prod=0;
                                $total_amount=0;
                            @endphp
                           @if(session('wishlist'))
                                @foreach(session('wishlist') as $wishlist_items)
                                    @php
                                        $total_prod+=$wishlist_items['quantity'];
                                        $total_amount+=$wishlist_items['amount'];
                                    @endphp
                                @endforeach
                           @endif
                            <a href="{{route('wishlist')}}" class="single-icon" ><i class="fa fa-heart-o"></i> <span  class="total-count" >{{Helper::wishlistCount()}} </span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                        <a href="{{route('wishlist')}}">View Wishlist</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                            @foreach(Helper::getAllProductFromWishlist() as $data)
                                                    @php
                                                        $photo=explode(',',$data->product['photo']);
                                                    @endphp
                                                    <li>
                                                        <a href="{{route('wishlist-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('cart')}}" class="btn animate">Cart</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                      
                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{Helper::cartCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                        <a href="{{route('cart')}}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                            @foreach(Helper::getAllProductFromCart() as $data)
                                                    @php
                                                        $photo=explode(',',$data->product['photo']);
                                                    @endphp
                                                    <li>
                                                        <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        <div class="sinlge-bar">

                        <select name="country" id="country" onchange="changeCurrency()">
                             
                        </select>                   
                </div> 
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">	
                                    <div class="nav-inner">	
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                                            {{-- <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">About Us</a></li> --}}
                                            <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="{{route('product-grids')}}">Products</a><span class="new"  style="background: #6fae2d ">New</span></li>												
                                                {{Helper::getHeaderCategory()}}
                                            {{-- <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Blog</a></li>									 --}}
                                               
                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
<script>
     const countries = [
        { code: "ES", name: "EUR" },    //EUR Spain     
        { code: "US", name: "USD" },  //USD united states
        { code: "KE", name: "KSH" }, //KSHs Kenya
        { code: "UG", name: "UGX" } //Uganda
    ];

    const select = document.getElementById("country");
    countries.forEach(country => {
        let option = document.createElement("option");
        option.value = country.code;
        option.textContent = country.name;
        select.appendChild(option);
    });
    
    const countryCurrencies = {
    FI: "EUR", DE: "EUR", KE: "KES", NO: "NOK", ES: "EUR", ZA: "ZAR", CH: "CHF", US: "USD", UG: "UGX"
};
async function fetchExchangeRates() {
        try {
            const response = await fetch("https://open.er-api.com/v6/latest/USD");
            const data = await response.json();
            return data.rates;
        } catch (error) {
            console.error("Error fetching exchange rates:", error);
            return null;
        }
    }

  async function changeCurrency() {
        const countrySelect = document.getElementById("country");
        const selectedCountry = countrySelect.value;
        const currencyCode = countryCurrencies[selectedCountry];

        console.log(selectedCountry);
        console.log(currencyCode);



        // if (!currencyCode) {
        //     aler
        //     return;
        // }


        const exchangeRates = await fetchExchangeRates();
        if (exchangeRates && exchangeRates[currencyCode]) {
            if (typeof localStorage !== "undefined") {
              
            localStorage.setItem("currencyCode", currencyCode );
            localStorage.setItem("currentExchange",exchangeRates[currencyCode] )
            console.log(exchangeRates[currencyCode]);
            } else {
                console.error("localStorage is not available.");
}
        } else {
            document.getElementById("exchangeRate").textContent = "N/A";
        }
        updatePrices();
    }


    function updatePrices() {
    console.log("Updating prices...");

    if (typeof localStorage !== "undefined") {
        const currencyCode = localStorage.getItem("currencyCode");
        const exchangeRate = localStorage.getItem("currentExchange");

        if (!currencyCode || !exchangeRate) return; // Exit if data is missing

        const rate = parseFloat(exchangeRate); // Convert to float

        document.querySelectorAll("#convertedPrice, #originalPrice").forEach(element => {
            let basePrice = parseFloat(element.getAttribute("data-price")); 
            if (!isNaN(basePrice)) {
                let convertedPrice = basePrice * rate; 
                element.textContent = `${currencyCode} ${convertedPrice.toFixed(2)}`;
            }
        });

        document.querySelectorAll(".product-price span").forEach(element => {
            let textPrice = element.textContent.replace(/[^0-9.]/g, "");
            let basePrice = parseFloat(textPrice);
            console.log(basePrice);
            if (!isNaN(basePrice)) {
                let convertedPrice = basePrice * rate;
                element.textContent = `${currencyCode} ${convertedPrice.toFixed(2)}`;
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