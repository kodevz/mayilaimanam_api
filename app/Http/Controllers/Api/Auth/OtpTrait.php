<?php

namespace App\Http\Controllers\Api\Auth;

use App\Mail\EmailVerifySuccess;
use App\Mail\RegistrationSuccess;
use App\Mail\SendOTP;
use App\Model\Auth\OtpConfirmation;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

trait OtpTrait
{
    
    /**
     * Check is email is verified
     *
     * @param [type] $email
     * @return void
     */
    public function checkIsEmailVerified(string $email) : array
    {
        $user = User::where('email', $email)->first();

        
        if ( $user && $user->is_verified == 0 ) {
            
            $this->generateOTP($email, EmailVerifySuccess::class);
            
            return [
                'status' => false,
                'action' => 'call_otp_verify'
            ];
        }

        return [
            'status' => true,
            'action' => '',
        ];
    }

    /**
     * Generate OTP 
     *
     * @param string $email
     * @param string $otpFor
     * @return void
     */
    public function generateOTP(string $email, string $otpFor = '') : void
    {
        
        OtpConfirmation::where('email', $email)->delete();

        $otp = new OtpConfirmation();
        $otp->otp = rand(1000, 9999);
        $otp->email = $email;
        $otp->otp_for = $otpFor;
        $otp->save();

        Mail::to($otp->email)->send(new SendOTP($otp));
       
    }

    /**
     * Resend OTP
     *
     * @param Request $request
     * @return void
     */
    public function resendOTP(Request $request) : array
    {
        $user = User::where('email', $request->get('email'))->get();

        if (count($user) == 0) {
            return [
                'status' => false,
                'msg' => 'Email not found our system. Please check and try again later'
            ];
        }

        $this->generateOTP($request->get('email'));

        return [
            'status' => true,
            'msg' => 'OTP Sent your email.'
        ];
    }

    public function otpVerification(Request $request)
    {

        $response = array();

        $enteredOtp = $request->input('otp');
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        $userId = $user->id;

        if ($userId == "" || $userId == null) {
            $response['error'] = 1;
            $response['message'] = 'You are logged out, Login again.';
            $response['loggedIn'] = 0;
        } else {

            $optRow = OtpConfirmation::where('email', $email)->first();
           
            if ($enteredOtp === $optRow->otp) {
                
                $otp = $optRow;

                $response['status'] = true;
                $response['error'] = 0;
                $response['is_verified'] = 1;
                $response['isLoggedIn'] = 1;
                $response['message'] = "You are verified";
                

                $this->sendResponseEmail($otp);

                $user->is_verified =  1;
                $user->save();
                $optRow->delete();
                
            } else {
                $response['error'] = 1;
                $response['status'] = false;
                $response['isVerified'] = 0;
                $response['loggedIn'] = 1;
                $response['message'] = "OTP does not match.";
            }
        }

        return $response;
    }

    private function sendResponseEmail(OtpConfirmation $otp) 
    {
        $emailFor = $otp->otp_for;

        if ($emailFor) {
            Mail::to($otp->email)->send(new $emailFor($otp));
        }
    }

    
}
