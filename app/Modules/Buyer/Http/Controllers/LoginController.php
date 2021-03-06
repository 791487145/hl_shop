<?php
namespace App\Modules\Buyer\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Modules\Buyer\Models\Buyer;
use App\Modules\Shopeeker\Models\Shopeeker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;
use DB;

class LoginController extends ApiController
{

    public function login(){
        if(Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])){
            $user = Auth::user();
            $role = $user->roles()->first();
            if($role->id != $this->buyer){
                return $this->formatResponse('暂无权限登录',$this->errorStatus);
            }
            $buyer = $user->buyer()->first();
            if($buyer->status == Buyer::STATUS_FORBBIN){
                return $this->formatResponse('该账号已禁止登录，请联系管理员',$this->errorStatus);
            }

            $user->oauth_access_token()->delete();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return $this->formatResponse('密码或账号错误',$this->errorLogin);
        }
    }

   /* public function checkMobile(Request $request,User $user)
    {
        $mobile = $request->post('mobile');
        $user = $user->whereMobile($mobile)->first();
        if(!is_null($user)){
            return $this->formatResponse('该手机号已注册');
        }

        return $this->formatResponse('验证成功');
    }*/


}