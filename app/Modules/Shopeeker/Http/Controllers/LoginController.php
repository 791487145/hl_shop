<?php
namespace App\Modules\Shopeeker\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Modules\Shopeeker\Models\Shopeeker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;
use DB;
use Hash;

class LoginController extends ApiController
{

    public function login(){
        if(Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])){
            $user = Auth::user();
            $role = $user->roles()->first();
            if($role->id != $this->shopeeker){
                return $this->formatResponse('暂无权限登录',$this->errorStatus);
            }
            $shopeeker = $user->shopeeker()->first();
            if($shopeeker->status == Shopeeker::STATUS_FAIL){
                return $this->formatResponse('该账号已禁止登录或账号在审核中，请联系管理员',$this->errorStatus);
            }

            $user->oauth_access_token()->delete();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return $this->formatResponse('密码或账号错误',$this->errorLogin);
        }
    }

    public function checkMobile(Request $request,User $user)
    {
        $mobile = $request->post('mobile');
        $user = $user->whereMobile($mobile)->first();
        if(!is_null($user)){
            return $this->formatResponse('该手机号已注册',$this->errorStatus);
        }

        return $this->formatResponse('验证成功');
    }

    public function aaa()
    {
        $pa = bcrypt(555555);
        dd($pa);
        if(Hash::check('555555',$pa)){
            dd(1);
        }
        dd(2);
    }

    public function register(Request $request)
    {
        DB::transaction(function () use($request) {
            $user = new User();
            $user->mobile = $request->post('mobile');
            $user->password = bcrypt($request->post('password'));
            $user->name = $request->post('agency_name');
            $user->status = $user::STATUS_DISABLE;
            $user->save();

            $user->assigeRole($this->shopeeker);

            $shopeeker = new Shopeeker();
            $shopeeker->business_agree_pic = $request->post('business_agree_pic');
            $shopeeker->business_code_pic = $request->post('business_code_pic');
            $shopeeker->sccial_agency_code_pic = $request->post('sccial_agency_code_pic');
            $shopeeker->agency_name = $request->post('agency_name');
            $shopeeker->agency_mobile = $request->post('agency_mobile');
            $shopeeker->province = $request->post('province');
            $shopeeker->city = $request->post('city');
            $shopeeker->area = $request->post('area');
            $shopeeker->agency_id_card = $request->post('agency_id_card');
            $shopeeker->brought_account = $request->post('brought_account');
            $shopeeker->brought_bank = $request->post('brought_bank');
            $shopeeker->brought_other_bank = $request->post('brought_other_bank');
            $shopeeker->content_person = $request->post('content_person');

            $shopeeker->company_name = $request->post('company_name');
            $shopeeker->business_code = $request->post('business_code');
            $shopeeker->business_agree = $request->post('business_agree');
            $shopeeker->sccial_agency_code = $request->post('sccial_agency_code');
            $shopeeker->status = $shopeeker::STATUS_FAIL;
            $shopeeker->user_id = $user->id;
            $shopeeker->save();
        });

        return $this->formatResponse('注册成功');
    }

}