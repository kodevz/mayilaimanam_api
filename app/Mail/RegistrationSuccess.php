<?php

namespace App\Mail;

use App\Model\Auth\OtpConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OtpConfirmation $otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Registration Success!')
                    ->view('mail.register');
    }
}
