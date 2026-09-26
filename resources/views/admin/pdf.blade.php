<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
      <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .invoice-table th ,td{
            border: 1px solid #000000;
        }
        .invoice-table th{
            padding: 10px;
            font-size: 20px;
            color: #000;
            font-weight: 700;

        }
        .invoice-table td {
            font-size: 18px;
            font-weight: 600;
            padding: 10px;
        }
    </style>
</head>

  <body>
    @foreach ($selectedOrders as $order)
    <div style="display: flex;align-items: center;justify-content: space-between;margin-bottom: 25px">
        <div style="width: 35%">
            <img src="{{ asset('/setting/'.$setting->logo) }}" style="max-height: 100px; width: 100px;" alt="logo" />
            {{-- <h2>Leramart</h2> --}}
        </div>
        <div style="width: 65%">
            <p style="margin-bottom: 0;font-size: 18px;font-weight: 600;color: #000;">
                কাঁচের জিনিস । ভঙ্গুর পণ্য । সাবধানে বহন করুন । আগে টাকা বুঝে পেয়ে পণ্য খুলে দেখতে দিন
                {{-- আগে পণ্য দেখে নিন, তার পরে টাকা দিন। --}}
            </p>
        </div>
    </div>
    <div style="display: flex;justify-content: space-between;">
        <div style="width: 33.33%;margin-right: 20px;">
            <p style="font-size: 18px;font-family: 'Open Sans', sans-serif;color: #000;margin-bottom: 5px;border-bottom: 1px solid #ddd;font-weight: 700;">
                Customer Info
            </p>
            <p  style="font-size: 18px;font-family: 'Open Sans', sans-serif;color: #000;font-weight: 600;margin-bottom: 0;">
                {{ $order->name }}<br> {{ $order->phone }}<br> {{ $order->address }}
            </p>
        </div>
        <div style="width: 33.33%;margin-right: 40px;">
            <p style="font-size: 18px;font-family: 'Open Sans', sans-serif;color: #000;margin-bottom: 5px;border-bottom: 1px solid #ddd;font-weight: 700;">
                Company Info
            </p>
            <p  style="font-size: 18px;font-family: 'Open Sans', sans-serif;color: #000;font-weight: 600;margin-bottom: 0;">
                {{env('APP_NAME')}}<br>For any query call: {{$setting->phone}} <br>{{$setting->address}}
            </p>
        </div>
        <div style="width: 33.33%;margin-top: 30px;">
            <p style="font-size: 18px; font-family: 'Open Sans', sans-serif; color: #000; vertical-align: top;margin-bottom:2px">
                <b>Order Number: {{ $order->orderId }}</b>
            </p>
            <p style="font-size: 18px; font-family: 'Open Sans', sans-serif; color: #000; vertical-align: top;margin-bottom:2px">
                <b>Order Date: {{ date('m/d/y', strtotime($order->created_at)) }}</b>
            </p>
            <p style="font-size: 18px; font-family: 'Open Sans', sans-serif; color: #000; vertical-align: top;margin-bottom:2px">
                <b>Operator: {{ $order->admin->name }}</b>
            </p>
            @if ($order->courier_name == 'Pathao')
            <p style="font-size: 18px; font-family: 'Open Sans', sans-serif; color: #000; vertical-align: top;margin-bottom:2px">
                <b>Courier: Pathao >> {{$order->pathao_city_name}} >> {{$order->pathao_zone_name}}</b>
            </p>
            @endif
        </div>
    </div>
    <!-- Header -->
    <table class="invoice-table" style="margin-bottom: 0px; border: 1px solid #000;width: 100%;margin-top: 15px;">
        <tr>
            <th>
                Item
            </th>
            <th>
                Quantity
            </th>
            <th>
                Price
            </th>
            <th>
                Size
            </th>
            <th>
                Color
            </th>
        </tr>
            @php
            $sum = 0;
            @endphp
            @foreach($order->orderDetails as $orderDetails)
                <tr>
                    <td style="width: 60%">
                        {{ $orderDetails->product->name }}
                    </td>
                    <td style="width: 20%">
                        {{ $orderDetails->qty }}
                    </td>
                    <td style="width: 20%;">
                        <!--{{$total = $orderDetails->price*$orderDetails->qty }} Tk.-->
                        {{$total = $orderDetails->price*$orderDetails->qty }}
                    </td>
                    <td style="width: 20%;">
                        {{ 'Size: '. $orderDetails->size }}
                    </td>
                    <td style="width: 20%;">
                        {{ 'Color: '. $orderDetails->color }}
                    </td>
                </tr>
                @php
                    $sum += $total;
                @endphp
            @endforeach
            <tr>
                <td></td>
                <td>
                    <strong>Subtotal</strong>
                </td>
                <td>
                    <strong>{{ $sum }} Tk.</strong>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <strong>Discount</strong>
                </td>
                <td>
                    <strong>{{ $order->discount??'0'}} Tk.</strong>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <strong>Delivery Charge</strong>
                </td>
                <td>
                    <strong>{{ $shipping = $order->area }} Tk.</strong>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <strong>Total</strong>
                </td>
                <td>
                    <!--<strong>{{ $shipping + $sum }} Tk.</strong>-->
                    {{ $order->price }} Tk.
                </td>
            </tr>
    </table>
    <!-- /Header -->
    <hr>
    @endforeach

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>

  </body>
</html>