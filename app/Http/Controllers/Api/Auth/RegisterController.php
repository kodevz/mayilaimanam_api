<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Model\Auth\OtpConfirmation;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function isEmailVerified(Request $request) 
    {
        return $this->checkIsEmailVerified($request->get('username'));
    }

    public function checkIsEmailVerified($email) 
    {
        $user = User::where('email', $email)->first();

        
        if ( $user && $user->is_verified == 0 ) {
            $this->sendOTP($email);
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

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'phone_no' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'cpassword' => 'required|same:password',
        ]);


        if ($validator->fails()) {

             return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $input['username'] = $input['username'];

        $user = User::updateOrCreate(['email' => $input['email']], $input);


        $roles = User::findOrFail($user->id)->roles();
        $roles->attach([4, 5]);


        $success['token'] =  $user->createToken('MAYILAIMANAM')->accessToken;
        $success['user'] =   $user;
        $success['msg'] =  'User created successfully';

        return response()->json(['success' => $success], 200);
    }


    public function registerFromUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'phone_no' => 'required',
            'password' => 'required',
            'cpassword' => 'required|same:password',
        ]);

        
        if ($validator->fails()) {

            $isEmailVerified = $this->checkIsEmailVerified($request->get('email'));
            $this->sendOTP($request->get('email'));
            return response()->json([
                'error' => $validator->errors(),
                'action' => $isEmailVerified['action']
            ], 401);
           
        }

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        unset($input['otp']);

        

        $user = User::updateOrCreate(['email' => $input['email']], $input);


        $roles = User::findOrFail($user->id)->roles();
        $roles->attach([4, 5]);

        $this->sendOTP($user->email);


 
        //$success['token'] =  $user->createToken('MAYILAIMANAM')->accessToken;
        $success['user'] =   $user;
        $success['msg'] =  'User created successfully';

        return response()->json(['success' => $success], 200);
    }
    
    public function sendOTP($email) 
    {
        
        OtpConfirmation::where('email', $email)->delete();

        $otp = new OtpConfirmation();
        $otp->otp = rand(1000, 9999);
        $otp->email = $email;
        $otp->save();

        $this->sendOTPMail($otp);
    }

    private function sendOTPMail(OtpConfirmation $otp) 
    {
        $data = [
            "otp" => $otp->otp
        ];
        Mail::send('otp', $data, function($message) use ($otp) {
            $message->to('karthi.php.developer@gmail.com', 'Otp')->subject('OTP Verification');
            $message->from('karthi.uk26@gmail.com','[QA] Test');
        });
    }


    public function resendOTP(Request $request) 
    {
        $this->sendOTP($request->get('email'));

        $user = User::where('email', $request->get('email'))->get();

        if (count($user) == 0) {
            return [
                'status' => false,
                'msg' => 'Email not found our system. Please check and try again later'
            ];
        }

        return [
            'status' => true,
            'msg' => 'OTP Sent your email.'
        ];
    }

    public function verifyOtp(Request $request)
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
                
                $user->is_verified =  1;
                $user->save();
                $optRow->delete();

                $response['status'] = true;
                $response['error'] = 0;
                $response['is_verified'] = 1;
                $response['isLoggedIn'] = 1;
                $response['message'] = "You are verified";
               
            } else {
                $response['error'] = 1;
                $response['status'] = false;
                $response['isVerified'] = 0;
                $response['loggedIn'] = 1;
                $response['message'] = "OTP does not match.";
            }
        }

        echo json_encode($response);
    }

    public function resetPassword(Request $request) 
    {
        
        $user = User::where('email', $request->get('email'))
                    ->update([
                        'password' => Hash::make($request->get('password'))
                    ]);
        
        return [
            'status' => true,
            'msg' => 'Your password reset successfully'
        ];
    }
}
