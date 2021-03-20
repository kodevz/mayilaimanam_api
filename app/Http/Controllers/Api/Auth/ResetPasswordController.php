<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordSuccess;
use App\Model\Auth\OtpConfirmation;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends RegisterController
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Reset Password
     *
     * @param Request $request
     * @return void
     */
    public function resetPassword(Request $request) 
    {
        
        User::where('email', $request->get('email'))
                    ->update([
                        'password' => Hash::make($request->get('password'))
                    ]);
        //Mail::to($request->get('email'))->send(new ResetPasswordSuccess());

        return [
            'status' => true,
            'msg' => 'Your password reset successfully'
        ];
    }
}
