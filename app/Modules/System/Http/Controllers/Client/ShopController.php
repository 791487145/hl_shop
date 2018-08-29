<?php
namespace App\Modules\System\Http\Controllers\Client;

use App\Modules\Shopeeker\Models\Shopeeker;
use App\Modules\System\Http\Controllers\SystemController;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;
use Hash;

class ShopController extends SystemController
{
    /**
     * 供应商列表
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function shopeekerList(Request $request)
    {
        $role = Auth::user()->roles->first();
        if($role->id == $this->shopeeker){
            $shopeeker = Shopeeker::whereUserId(Auth::id())->select('id','company_name','agency_name','agency_mobile','status','ssl_num_status','province','city','area')->get();
        }else{
            $shopeeker = Shopeeker::orderBy('id','desc')->select('id','company_name','agency_name','agency_mobile','status','ssl_num_status','province','city','area')
                ->forPage($request->post('page',1),$request->post('limit',$this->limit))->orderBy('id','desc')->get();
        }

        foreach ($shopeeker as &$value){
            $value = Shopeeker::shopeeker($value);
        }

        return $this->formatResponse('获取成功',$this->successStatus,$shopeeker);
    }

    /**
     * 供应商详情
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function shopeekerInfo(Request $request)
    {
        $shopeeker = Shopeeker::whereId($request->post('shopeeker_id'))->first();
        $shopeeker = Shopeeker::shopeeker($shopeeker);

        return $this->formatResponse('获取成功',$this->successStatus,$shopeeker);
    }

    /**
     * 密码重置
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function passwordReset(Request $request)
    {
        $shopeeker = Shopeeker::whereId($request->post('shopeeker_id'))->first();
        $user = $shopeeker->user();
        $user->update(['password' => bcrypt($request->post('new_password'))]);
        return $this->formatResponse('修改成功');
    }

    /**
     * 更改状态
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request)
    {
        $user_id = Auth::id();
        $u_id = Shopeeker::whereId($request->post('shopeeker_id'))->value('user_id');
        if($user_id == $u_id){
            return $this->formatResponse('自己不能对自己操作哦');
        }

        User::whereId($u_id)->update(['status' => $request->post('status')]);
        Shopeeker::whereId($request->post('shopeeker_id'))->update(['status' => $request->post('status')]);
        return $this->formatResponse('操作成功');
    }

}