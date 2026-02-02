<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/favicon.png" rel="icon"/>
    <title>shopz.ge</title>
    <meta name="author" content="harnishdesign.net">
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" type="text/css" href="{{asset('frontassets/invoice/invoice.css')}}"/>
</head>
<body>
<!-- Container -->
<div class="container-fluid invoice-container">
    <!-- Header -->
    <header>
        <div class="row gy-3">
            <a href="https://shopz.ge/" class="col-sm-3">
                <img id="logo" width="100" src="{{asset('shopz_man2.jpeg')}}" title="shopz.ge" alt="shopz.ge"/>
            </a>
            <div class="col-sm-7">
                <h4 class="text-4 mb-1">Sold By: Koice Inc.</h4>
                {{--                <p class="lh-base mb-0">Ship-from Address: Koice Inc, 2705 N. Enterprise St, Orange, CA 92865</p>--}}
            </div>
            <div class="col-sm-2">
                <strong>{{__('Invoice')}} No:</strong> {{$order->order_token}}
            </div>
        </div>
        <hr>
    </header>

    <!-- Main Content -->
    <main>
        <div class="row gy-3">
            <div class="col-sm-4">
                <p class="mb-1"><strong>{{__('Order2')}} No:</strong> {{$order->order_token}}</p>
                <p class="mb-1"><strong>{{__('Order date')}}:</strong> {{$order->created_at->format('d/m/Y')}}</p>
            </div>
            <div class="col-sm-2"><strong>{{__('Buyer')}}</strong>
                <address>
                    {{auth()->user()->name}}
                    <br/>
                    {{auth()->user()->pid}}
                    01024064358
                </address>
            </div>
            <div class="col-sm-6"><strong>{{__('Delivery Address')}}</strong>
                <address>
                    {{$order->city->name}}<br/>
                    {{$order->address}}<br/>
                </address>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table border mb-0">
                <thead>
                <tr class="bg-light">
                    <td class="col-5"><strong>Product</strong></td>
                    <td class="col-1 text-center"><strong>QTY</strong></td>
                    <td class="col-2 text-center"><strong>Price</strong></td>
                    <td class="col- text-end"><strong>Total</strong></td>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products_details as $item)
                    <tr>
                        <td class="col-5">
                            {{$item['name']}}
                        </td>
                        <td class="text-center">{{$item['quantity']}}</td>
                        <td class="col-2 text-center">{{$item['price']}}</td>
                        <td class="col-2 text-end">{{$item['product_total']}}</td>
                    </tr>
                @endforeach
                @if($order->presents!=null)
                    @foreach($order->presents as $present)
                        <tr>
                            <td class="col-5">
                                {{$item['name']}}
                            </td>
                            <td class="text-center">{{$item['quantity']}}</td>
                            <td class="col-2 text-center">{{$item['price']}}</td>
                            <td class="col-2 text-end">{{$item['product_total']}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table border border-top-0 mb-0">
                <tr class="bg-light">
                    <td class="text-end"><strong>{{__('Total')}}:</strong></td>
                    <td class="col-sm-2 text-end">{{$order->grand_total}}</td>
                </tr>
                {{--                <tr class="bg-light">--}}
                {{--                    <td class="text-end"><strong>Tax:</strong></td>--}}
                {{--                    <td class="col-sm-2 text-end">$15.00</td>--}}
                {{--                </tr>--}}
                {{--                <tr class="bg-light">--}}
                {{--                    <td class="text-end"><strong>Grand Total:</strong></td>--}}
                {{--                    <td class="col-sm-2 text-end">$292.00</td>--}}
                {{--                </tr> --}}
            </table>
        </div>
    </main>
    <div class="d-flex justify-content-center mt-1"><span class="color-green-dark">{{__('Paid')}}</span></div>
    <!-- Footer -->
    <footer class="mt-5">

        <p class="text-0 mb-0"><strong>Returns Policy:</strong> At Koice we try to deliver perfectly each and every
            time. But in the off-chance that you need to return the item, please do so with the original Brand box/price
            tag, original packing and invoice without which it will be really difficult for us to act on your request.
            Please help us in helping you. Terms and conditions apply.</p>
        <hr class="my-2">
        <p class="text-center">Helpline: 1800 222 9888</p>
        <div class="text-center">
            <div class="btn-group btn-group-sm d-print-none">
                <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i
                        class="fa fa-print"></i> {{__('Print & Download')}}
                </a></div>
        </div>
    </footer>
</div>
</body>
</html>
