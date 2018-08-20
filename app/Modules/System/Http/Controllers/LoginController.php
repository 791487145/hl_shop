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
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            if($user->status != 1){
                return $this->formatResponse('该用户已被禁止登陆',$this->errorStatus);
            }
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    /* public function getDetails(Request $request)
    {
        //Log::alert('res'.print_r($request,true));
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }*/
}