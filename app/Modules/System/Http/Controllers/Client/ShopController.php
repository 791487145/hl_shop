<?php
namespace App\Modules\System\Http\Controllers\Client;

use App\Http\Controllers\ApiController;
use App\Modules\Shopeeker\Models\Shopeeker;
use App\Modules\System\Http\Controllers\SystemController;
use App\Modules\System\Models\AuthMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class ShopController extends SystemController
{

    public function shopeekerList(Request $request)
    {
        $role = Auth::user()->roles->first();
        if($role->id == $this->shopeeker){
            $shopeeker = Shopeeker::whereUserId(Auth::id())->select('id','company_name','agency_name','agency_mobile','status','ssl_num_status','province','city','area')->first();
            $shopeeker = Shopeeker::shopeeker($shopeeker);
        }else{
            $shopeeker = Shopeeker::orderBy('id','desc')->select('id','company_name','agency_name','agency_mobile','status','ssl_num_status','province','city','area')->paginate(10);
            foreach ($shopeeker as &$value){
                $value = Shopeeker::shopeeker($value);
            }
        }

        return $this->formatResponse('获取成功',$this->successStatus,$shopeeker);
    }

    public function shopeekerInfo(Request $request)
    {
        $shopeeker = Shopeeker::whereId($request->post('shopeeker_id'))->first();
        $shopeeker = Shopeeker::shopeeker($shopeeker);

        return $this->formatResponse('获取成功',$this->successStatus,$shopeeker);
    }

    public function passwordReset(Request $request)
    {
        $user = Auth::user();

        if($user->password != bcrypt($request->post('old_password'))){
            return $this->formatResponse('原密码不正确');
        }
        $user->update(['password' => $request->post('new_password')]);
        return $this->formatResponse('修改成功');
    }

    public function statusChange(Request $request)
    {
        $user_id = Auth::id();
        $u_id = Shopeeker::whereId($request->post('shopeeker_id'))->pluck('user_id');
        if($user_id == $u_id){
            return $this->formatResponse('自己不能对自己操作哦');
        }

        User::whereId($u_id)->update(['status' => $request->post('status')]);
        Shopeeker::whereId($request->post('shopeeker_id'))->update(['status' => $request->post('status')]);
        return $this->formatResponse('操作成功');
    }

}