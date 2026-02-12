@php
    $details = json_decode($order->callback_data, true);
@endphp
<a href="#" data-bs-toggle="offcanvas"
   data-bs-target="#order_transaction_{{$order->order_token}}"
   class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s  mb-0 ">
    {{__('Payment Details')}}
</a>
{{-- @dd($details) --}}
<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100"
     style=" max-width:450px; max-height: 78vh; overflow-y: auto; overflow-x: hidden;"
     id="order_transaction_{{$order->order_token}}">
    <div class="content">
        <div class="d-flex justify-content-center">
            <h5 class="text-center">{{__('Order No')}} {{$order->order_token}} - {{$order->created_at->format('d/m/Y')}}</h5>
        </div>
        <div class="card card-style">
            <div class="content text-start">
                <h5  class="text-center">{{__('Payment Details')}}</h5>
                <div class="divider mt-3"></div>
                <p class="mb-1">
                    <strong>Card :</strong> {{ strtoupper($details['body']['payment_detail']['card_type']) }}
                    ({{ $details['body']['payment_detail']['payer_identifier'] }})
                </p>
                <p class="mb-1">
                    <strong>order_id :</strong>
                    {{ $details['body']['order_id'] }}
                </p>
                <p class="mb-1">
                    <strong>transaction_id :</strong>
                    {{ $details['body']['payment_detail']['transaction_id'] }}
                </p>
                <p class="mb-1">
                    <strong>payer_identifier :</strong>
                    {{ $details['body']['payment_detail']['payer_identifier'] }}
                </p>
                <p class="mb-1">
                    <strong>card_type :</strong>
                    {{ $details['body']['payment_detail']['card_type'] }}
                </p>
                <p class="mb-1">
                    <strong>card_expiry_date :</strong>
                    {{ $details['body']['payment_detail']['card_expiry_date'] }}
                </p>
                <p class="mb-1">
                    <strong>pg_trx_id :</strong>
                    {{ $details['body']['payment_detail']['pg_trx_id'] }}
                </p>
                <p class="mb-1">
                    <strong>auth_code :</strong>
                    {{ $details['body']['payment_detail']['auth_code'] }}
                </p>
            </div>
        </div>
        <div class="d-flex justify-content-center gap-2 mt-2">
            <button type="button" data-bs-dismiss="offcanvas" class="btn btn-full bg-highlight shadow-bg shadow-bg-s">
                {{__('Close')}}
            </button>
        </div>
    </div>
</div>
