<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\appointment_booking;
use Validator;
use App\Http\Resources\BookingCollection as BookingResource;
use Mail;
use App\Mail\AppointmentEmail;
use App\Models\User;

class AppointmentController extends BaseController
{
   // public function __construct()
    //{
      //  $this->middleware('auth:api')->except('index', 'show', 'store', 'update', 'destroy');
    //}
    
    public function index()
    {
        $appointment = appointment_booking::get();
        return $this->sendResponse(BookingCollection::collection($appointment), 'Appointment Booking retrieved successfully.');
    }

    

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'appointment_date' => 'required',
            'appointment_time' => 'required',
            'contact_address' => 'required',
            'user_id' => 'required',
            'appointment_type_id' => 'required',
            'complaint' => 'required'
        ]);
        
        $booking = appointment_booking::create($validatedData);
        $user = User::find($request->user_id);

        Mail::to($user->email)->send(new AppointmentEmail($user, $booking, "Appointment created"));

        return response()->json(['message' => 'Appointment Booking was created successfully.'], 200);
        
    } 
 
    public function show($id)
    {
        $booking = appointment_booking::find($id);

        if (is_null($booking)) {
            return $this->sendError('Appointment not found.');
        }

        return $this->sendResponse(new BookingResource($booking), 'Appointment Booking retrieved successfully.');
    }

    public function update(Request $request, appointment_booking $booking)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'appointment_date' => 'required',
            'appointment_time' => 'required',
            'user_id' => 'required',
            'contact_address' => 'required',
            'appointment_type_id' => 'required',
            'complaint' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $booking->appointment_date = $input['appointment_date'];
        $booking->appointment_time = $input['appointment_time'];
        $booking->user_id = $input['user_id'];
        $booking->contact_address = $input['contact_address'];
        $booking->appointment_type_id = $input['appointment_type_id'];
        $booking->complaint = $input['complaint'];
        $booking->save();

        $user = User::find($request->user_id);
        Mail::to($user->email)->send(new AppointmentEmail($user, $booking, "Appointment changed"));

        return $this->sendResponse(new BookingResource($booking), 'Appointment Booking updated successfully.');
    }

    public function destroy(appointment_booking $booking)
    {
        $booking->delete();
        return $this->sendResponse([], 'Appointment Booking deleted successfully.');
    }
}
