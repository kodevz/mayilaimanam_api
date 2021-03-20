<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationSuccess;
use App\Model\Auth\OtpConfirmation;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use OtpTrait;

    protected $request;

    protected $otpText = 'You have requested to reset your password';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function isEmailVerified(Request $request) 
    {
        return $this->checkIsEmailVerified($request->get('username'));
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

            // $isEmailVerified = $this->checkIsEmailVerified($request->get('email'));

            // $this->generateOTP($request->get('email'));

            return response()->json([
                'error' => $validator->errors()
            ], 401);
           
        }

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
        $input['is_verified'] = 1;

        unset($input['otp']);

        $user = User::updateOrCreate(['email' => $input['email']], $input);


        $roles = User::findOrFail($user->id)->roles();
        $roles->attach([4, 5]);

        $success['user'] =   $user;
        $success['msg'] =  'Your are register successfully';

        return response()->json($success, 200);
    }
    
  
    /**
     * Verify OTP
     *
     * @param Request $request
     * @return void
     */
    public function verifyOtp(Request $request)
    {
        $response = $this->otpVerification($request);

        return $response;
    }

}
