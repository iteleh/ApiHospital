<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Mail\AppointmentEmail;
use App\Mail\PaymentEmail;
use App\Models\User;
use App\Models\appointment_booking;
use App\Models\payment;
use App\Models\payment_plan;
use App\Models\payment_type;
use App\Http\Resources\PaymentCollection;
use Carbon\Carbon;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $payment = payment::get();
        return response()->json([PaymentCollection::collection($payment), 'Payment retrieved successfully.'], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validatedData = $request->validate([
            'user_id' => 'required',
            'appointment_id' => 'required',
            'payment_date' => 'required',
            'payment_type_id' => 'required',
            'payment_plan_id' => 'required',
            'amount_paid' => 'required',
        ]);

      
        $user = User::find($request->user_id);
        $payment = payment::create($validatedData);
        
        Mail::to($user->email)->send(new PaymentEmail($user, $payment, "Payment Created Successfully"));

        return response()->json(['message' => 'Payment Created successfully'], 200);

    }
    

   public function flutterHandleWebhook(Request $request)
   {
        $paymentData = $request->all();

        if ($paymentData['event'] === 'payment.completed') {
            // Payment completed, do something
            $email = $paymentData['data']['customer']['email'];

            $user = User::where('email', $email)->first();
            $payment = Payment::where('user_id', $user->id)->where('status', 'Pending')->where('payment_type_id',2)->first();

           
                $booking = appointment_booking::find($payment->appointment_id);

                $payment->status = "Paid";
                $payment->save();


                $booking->status = 2;
                $booking->save();

                Mail::to($user->email)->send(new PaymentEmail($user, $payment, "Payment Received"));
                Mail::to($user->email)->send(new AppointmentEmail($user, $booking, "Payment has been received"));
            

        } 
        else if ($paymentData['event'] === 'payment.failed') {
            // Payment failed, do something

            $email = $paymentData['data']['customer']['email'];

            $user = User::where('email', $email)->first();
            $payment = Payment::where('user_id', $user->id)->where('status', 'pending')->where('payment_type_id',2)->first();

           
            $booking = appointment_booking::find($payment->appointment_id);
            Mail::to($user->email)->send(new PaymentEmail($user, $payment, "Payment Cancelled"));
            
        }

    }

   public function PaystackHandleWebhook(Request $request)
   {
        $paymentData = $request->all();

        if ($paymentData['event'] === 'charge.success') {
            // Payment completed, do something
            $email = $paymentData['data']['customer']['email'];

            $user = User::where('email', $email)->first();
            $payment = Payment::where('user_id', $user->id)->where('status', 'pending')->where('payment_type_id',2)->first();

            
            $booking = appointment_booking::find($payment->appointment_id);

            $payment->status = "Paid";
            $payment->save();


            $booking->status = 2;
            $booking->save();

            Mail::to($user->email)->send(new PaymentEmail($user, $payment, "Payment Received"));
            Mail::to($user->email)->send(new AppointmentEmail($user, $booking, "Payment has been received"));
            

        } 
    }
}
