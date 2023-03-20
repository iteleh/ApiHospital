{{-- blade-formatter-disable --}}
@component('mail::message')
# Hello {{$user->name}}, 

Your payment details
<br><br>
Date: $payment->payment_date <br><br>
Amount: $payment->amount_paid <br><br>
@if($payment->payment_type_id == 1)
Payment Method: Flutterwave
@else
Payment Method: Paystack
@endif

@if($payment->status == 1)
Status: Pending
@elseif($payment->status == 2)
Status: Approved
@else
Status: Cancelled
@endif

<br> <br>

Thanks, and welcome.<br>
{{ config('app.name') }}
@endcomponent
{{-- blade-formatter-disable --}}