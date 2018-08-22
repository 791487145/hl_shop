<?php
namespace App\Modules\System\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class LoginController extends ApiController
{

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])){
            $user = Auth::user();
            //dd($user);
            if($user->status != 1){
                return $this->formatResponse('该用户已被禁止登陆',$this->errorStatus);
            }

            $user->oauth_access_token()->delete();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

}