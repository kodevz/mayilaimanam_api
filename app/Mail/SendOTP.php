<?php

namespace App\Mail;

use App\Model\Auth\OtpConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class SendOTP extends Mailable
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
        $this->otp =  $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('OTP Verification')
                    ->view('mail.otp')
                    ->with([
                        'otp' => $this->otp->otp,
                        'otpText' => ''
                    ]);
    }
}
