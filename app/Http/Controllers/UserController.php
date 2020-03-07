<?php

namespace App\Http\Controllers;

use App\User as AppUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    /**
     * Show the single category by id
     *
     * @param int $id
     * @return void
     */
    public function sessionUser(Request $request)
    {
        $user = AppUser::with('roles')->find($request->user());

        return $user;
    }
    
}
