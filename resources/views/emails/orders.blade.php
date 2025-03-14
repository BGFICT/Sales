<x-mail::message>
Hello {{$customer->name}},

Your Order No.{{$order->id}} has been placed successfully and is now being processed

You can view your order details using the link below.

<x-mail::button :url="$order_url">
Download Magazine</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
=======
You will be contacted via our company phone number within 24 hours.  

If not, feel free to contact us at: **+254 110 066 043**.

<x-mail::button :url="$order_url">
View Order
</x-mail::button>

Thanks for shopping with us,<br>
{{ config('app.name') }}

**Kind regards,**  
**Better Globe Forestry Ltd**


To see to our Latest Magazine Issues Click <x-mail::button :url="'https://miti-magazine.betterglobeforestry.com/'">SUBSCRIBE</x-mail::button>

</x-mail::message>