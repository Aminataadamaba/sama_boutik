<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">

    @if ($mailData['userType'] == 'customer')
        <h1>Merci pour votre Commande!!</h1>
        <h2>Your Order Id Is: #{{ $mailData['order']->id }}</h2>
     @else
        <h1>Vous avez recu une commande:</h1>
        <h2>Order Id: #{{ $mailData['order']->id }}</h2>
    @endif

    <h1>Shipping Address</h1>
    <address>
        <strong>{{ $mailData['order']->first_name.' '.$mailData['order']->last_name }}</strong><br>
        {{ $mailData['order']->address }}<br>
        {{ $mailData['order']->city }}, {{ $mailData['order']->zip }},{{ getCountryInfo($mailData['order']->country_id)->name }}<br>
        Phone: {{ $mailData['order']->mobile }}<br>
        Email: {{ $mailData['order']->email }}
    </address>

    <h2>Products</h2>
    <table cellpadding="3" cellspacing="3" border="0" width="700">
        <thead>
            <tr style="background: #CCC;">
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mailData['order']->items as $item)


            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->price }}Fcf</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->total }}Fcf</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="3" align="right">Subtotal:</th>
                <td>{{ $mailData['order']->subtotal }}Fcf</td>
            </tr>
            <tr>
                <th colspan="3" align="right">Discount: {{ (!empty($mailData['order']->coupon_code)) ? '('.$mailData['order']->coupon_code.')' : '' }}</th>
                <td>{{ $mailData['order']->discount }}Fcf</td>
            </tr>

            <tr>
                <th colspan="3" align="right">Shipping:</th>
                <td>{{ $mailData['order']->shipping }}Fcf</td>
            </tr>
            <tr>
                <th colspan="3" align="right">Grand Total:</th>
                <td>{{ $mailData['order']->grand_total }}Fcf</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
