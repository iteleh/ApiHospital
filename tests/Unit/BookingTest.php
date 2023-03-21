<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\appointment_booking;

class BookingTest extends TestCase
{
    public function testRequiredFieldsForBooking()
    {
        $this->json('POST', 'api/appointments', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "appointment_date" => ["The appointment date field is required."],
                    "appointment_time" => ["The appointment time field is required."],
                    "contact_address" => ["The contact address field is required."],
                    "user_id" => ["The user id field is required."],
                    "appointment_type_id" => ["The appointment type id field is required."],
                    "complaint" => ["The complaint field is required."],
                ]
            ]);
    }
    public function testSuccessfulBooking()
    {
        $bookingData = [
            "user_id" => "1",
            "appointment_time" => "7am",
            "appointment_date" => "2023-03-21",
            "contact_address" => "Akwa Ibom State",
            "appointment_type_id" => "1",
            "complaint" => "Headache with toothace"
        ];

        $this->json('POST', 'api/appointments', $bookingData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }
}
