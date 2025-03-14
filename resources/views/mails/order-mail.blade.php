<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>
<P> Hi {{ $order->firstname }} {{ $order->name }}
    <h1>Order Confirmation</h1>
    <p>Thank you for your order. Here are your order details:</p>

    <p>Order ID: {{ $order->id }}</p>
    <p>Order Total: {{ $order->total_amount }}</p>
    <!-- Add more order details as needed -->

     <table style="width: 600px; text-align:right">
        <thead> 
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
            <tbody>
                @foreach ($order->oderItems as $item )
                <tr>
                    <td>
                        <img scr="{{ asset('assets/images/products') }}/ {{ $item->product->image }}" width="100">
                        {{-- D:\eccomas laravel\SalesPage\storage\app\public\photos\1\Products --}}
                    {{-- </td>
                    <td>
                        {{ $item->product->name }}
                    </td>
                    <td>
                        {{ $item->quantity }}
                    </td>
                    <td>
                        {{ $item->price * $item->quantity  }}
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3"></td>
                    <td style="font-size: 15px; font-weight:bold;border-top:1px solid #ccc">Sub-Total : ${{ $order->subtotal }}</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td style="font-size: 15px; font-weight:bold;">Tax : ${{ $total_amount->tax }}</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td style="font-size: 15px; font-weight:bold;">Shipping : {{ $total_amount->shipping }}</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td style="font-size: 15px; font-weight:bold;">Total : ${{ $total_amount->total }}</td>
                </tr>

            </tbody>
    </table> --}} 

    <!-- resources/views/emails/invoice.blade.php -->
<h1>Invoice for Your Payment</h1>
<p>Thank you for your payment of ${{ $invoiceData['total_amount'] }}.</p>

<h2>Purchased Items:</h2>
<ul>
    @foreach($invoiceData['items'] as $item)
        <li>{{ $item['name'] }} - ${{ $item['price'] }}</li>
    @endforeach
</ul>

<p>Total: ${{ $invoiceData['total_amount'] }}</p>

<p>The Download link for your magazine is: {{$url}}</p>

</body>
</html>
