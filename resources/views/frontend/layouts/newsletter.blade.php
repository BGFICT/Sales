
<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
    <div class="container">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <!-- Start Newsletter Inner -->
                    <div class="inner">
                        <h4>Newsletter</h4>
                        <p> Subscribe to our newsletter and get 
                             your first purchase</p>
                        <form action="{{route('subscribe')}}" method="post" class="newsletter-inner" name="submit-to-google-sheet">
                            @csrf
                            <input name="email" placeholder="Your email address" required="" type="email">
                            <button class="btn" type="submit" value="Subscribe" style="background: rgb(12, 170, 38)">Subscribe</button>
                        </form>
                        <span id="msg"></span>

                    </div>

                    

                    <script>
                        const scriptURL = 'https://script.google.com/macros/s/AKfycbxgpjBJ--x9xIiqCN9vMq4AbKGz26dZ6JVhT83LOQCuQhWh6XvrcPmuMySLXcliazpDJw/exec'
                        const form = document.forms['submit-to-google-sheet']
                        const msg = document.getElementById("msg")
                      
                        form.addEventListener('submit', e => {
                          e.preventDefault()
                          fetch(scriptURL, { method: 'POST', body: new FormData(form)})
                            .then(response => {
                                msg.innerHTML = "Thank you for Subscribing!"
                                setTimeout(function(){
                                  msg.innerHTML = ""
                                },5000) 
                                form.reset()
                            }
                            )
                            .catch(error => console.error('Error!', error.message))
                        })
                      </script>
                    <!-- End Newsletter Inner -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Newsletter -->