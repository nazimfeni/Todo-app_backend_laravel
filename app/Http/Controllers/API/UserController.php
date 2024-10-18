<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * The loginUser function is used for login through api.
     */
    public function loginUser(Request $request): Response
    {
        $input = $request->all();
        Auth::attempt($input);
        $user = Auth::user(); 
        $token = $user->createToken('example')->accessToken; // bearer token will be created here and it has to be set in postman
        // return Response(['status' => 200,'token'=> $token],200);   
        return Response(['status' => 200, 'token' => $token],200);
    }   

    /**
     * The getUserDetail function is used for getting user information.
     */
    public function getUserDetail(): Response
    {
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
            return Response(['data' => $user],200);
        }
        return Response(['data' => 'Unauthorized'],401);
    }


    /**
     * The userLogout function is used for logout the transaction
     */
    public function userLogout(): Response
    {
        if(Auth::guard('api')->check()){
            $accessToken = Auth::guard('api')->user()->token();

                \DB::table('oauth_refresh_tokens')
                    ->where('access_token_id', $accessToken->id)
                    ->update(['revoked' => true]);
            $accessToken->revoke();

            return Response(['data' => 'Unauthorized','message' => 'User logout successfully.'],200);
        }
        return Response(['data' => 'Unauthorized'],401);
    }

   
}