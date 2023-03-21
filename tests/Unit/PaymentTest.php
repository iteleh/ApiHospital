<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\payment;

class PaymentTest extends TestCase
{
    
    public function testRequiredFieldsForPayment()
    {
        $this->json('POST', 'api/payments', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "user_id" => ["The user id field is required."],
                    "appointment_id" => ["The appointment id field is required."],
                    "payment_date" => ["The payment date field is required."],
                    "payment_type_id" => ["The payment type id field is required."],
                    "payment_plan_id" => ["The payment plan id field is required."],
                    "amount_paid" => ["The amount paid field is required."],
                ]
            ]);
    }
    public function testSuccessfulPayment()
    {
        $paymentData = [
            "user_id" => "1",
            "appointment_id" => "1",
            "payment_date" => "2023-03-21",
            "payment_type_id" => "1",
            "payment_plan_id" => "1",
            "amount_paid" => "5000"
        ];

        $this->json('POST', 'api/payments', $paymentData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure(["message"]);
    }

    public function testSuccessfulFlutterwavePayment()
    {
        $payload = [
            "event" => "payment.completed",
            "data"=> [
                "amount" => "5000",
                "customer" => [
                    "email" => "iteleh97@gmail.com",
                ],
            ],
        ];

        

        $this->postJson('/flutter/webhook', $payload)
            ->assertStatus(200);
    }

    public function testSuccessfulPaystackPayment()
    {
        $payload = [
            "event" => "charge.success",
            "data"=> [
                "amount" => "5000",
                "customer" => [
                    "email" => "iteleh97@gmail.com",
                ],
            ],
        ];

        

        $this->postJson('/paystack/webhook', $payload)
            ->assertStatus(200);
    }
    
    public function testSuccessfulListedPayment()
    {
        $payload = [
            "event" => "charge.success",
            "data"=> [
                "amount" => "5000",
                "customer" => [
                    "email" => "iteleh97@gmail.com",
                ],
            ],
        ];

        

        $this->Json('GET','/api/payments', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

   
}
