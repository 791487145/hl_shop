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

            $data = array(
                'token' => $success['token'],
                'user_name' => $user->name,
                'user_id' => Auth::id()
            );
            return $this->formatResponse('登录成功',$this->successStatus,$data);
        }
        else{
            return $this->formatResponse('密码或账号错误',$this->errorLogin);
        }
    }

}