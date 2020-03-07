<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;  
    }
    
    

    public function register(Request $request) 
    { 
    
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email|unique:users,email', 
            'first_name' => 'required', 
            'last_name' => 'required', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);

        if ($validator->fails()) {    
            return response()->json(['error'=> $validator->errors()], 401);            
        }

        $input = $request->all(); 

        $input['password'] = bcrypt($input['password']); 

        $user = User::updateOrCreate(['email' => $input['email'] ], $input); 
        

        $roles = User::findOrFail($user->id)->roles();
        $roles->attach([4, 5]);
       

        $success['token'] =  $user->createToken('MAYILAIMANAM')->accessToken; 
        $success['user'] =   $user; 
        $success['msg'] =  'User created successfully';
      
        return response()->json(['success' => $success], 200); 
    }
}
