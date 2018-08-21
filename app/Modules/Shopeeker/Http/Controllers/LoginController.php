<?php
namespace App\Modules\Shopeeker\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class LoginController extends ApiController
{

    public function login(){
        if(Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])){
            $user = Auth::user();
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

    public function checkMobile(Request $request,User $user)
    {
        $mobile = $request->post('mobile');
        $user = $user->whereMobile($mobile)->first();
        if(!is_null($user)){
            return $this->formatResponse('该手机号已注册');
        }

        return $this->formatResponse('验证成功');
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->mobile = $request->post('mobile');
        $user->password = bcrypt($request->post('password'));
        $user->name = $request->post('mobile');
        $user->status = $user::STATUS_DISABLE;
        $user->save();

        $user->assigeRole($this->shopeeker);
    }

}