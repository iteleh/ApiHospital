{{-- blade-formatter-disable --}}
@component('mail::message')
# Hello {{$user->name}}, 

Your payment details
<br><br>
Date: {{$payment->payment_date}} <br><br>
Amount: {{$payment->amount_paid }}<br><br>
@if($payment->payment_type_id == 1)
Payment Method: Flutterwave
@else
Payment Method: Paystack
@endif
<br><br>
@if($payment->status == "1")
Status: Pending
@endif
@if($payment->status == "2")
Status: Approved
@endif
@if($payment->status == "3")
Status: Cancelled
@endif

<br> <br>

Thanks, and welcome.<br>
{{ config('app.name') }}
@endcomponent
{{-- blade-formatter-disable --}}