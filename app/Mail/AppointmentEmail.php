<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\appointment_booking;


class AppointmentEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $appointment;
    public $user;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, appointment_booking $data, $subject)
    {
        $this->appointment = $data;
        $this->user = $user;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.appointment')->subject($this->subject);
    }
}
