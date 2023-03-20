<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\payment;


class PaymentEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $payment;
    public $user;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, payment $data, $subject)
    {
        $this->payment = $data;
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
        return $this->markdown('emails.payment')->subject($this->subject);
    }
}
