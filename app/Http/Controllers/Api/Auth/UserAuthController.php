<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

use Lcobucci\JWT\Parser;

class UserAuthController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function whoAmI(Request $request)
    {
        return Response::json($request->user());
    }
    
    /**
     * Auth User Api Logout
     *
     * @return void
     */
    public function logoutApi(Request $request)
    {

        $value = $request->bearerToken();
       
        $id = (new Parser())->parse($value)->getHeader('jti');
        $token =  $request->user()->tokens->find($id);
        $token->revoke();
        $response = 'Successfully log out';
        return Response::json($response);
      
    }

}
