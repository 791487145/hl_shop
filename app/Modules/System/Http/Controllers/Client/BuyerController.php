<?php
namespace App\Modules\System\Http\Controllers\Client;

use App\Http\Controllers\ApiController;
use App\Modules\Buyer\Models\Buyer;
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
use DB;

class BuyerController extends SystemController
{

    public function buyerList(Request $request)
    {
        $role = Auth::user()->roles->first();
        if($role->id == $this->buyer){
            $buyer = Buyer::whereUsersId(Auth::id())->select('id','account_num','use_account','debt_account_num','mobile','agency_name','ssl_num_status','status')->first();
            $buyer = Buyer::buyer($buyer);
        }else{
            $status = $request->post('status',1);
            $buyer = new Buyer();
            $buyer = $buyer->whereStatus($status)->select('id','account_num','use_account','debt_account_num','mobile','agency_name','ssl_num_status','status')->orderBy('id','desc')->get();
            foreach ($buyer as &$value){
                $value = Buyer::buyer($value);
            }
        }

        return $this->formatResponse('获取成功',$this->successStatus,$buyer);
    }

    public function buyerCreate(Request $request)
    {
        $user = User::whereMobile($request->post('mobile'))->first();
        if(!is_null($user)){
            return $this->formatResponse('该手机号已注册');
        }

        DB::transaction(function () use($request) {
            $user = new User();
            $user->mobile = $request->post('mobile');
            $user->password = bcrypt($request->post('password'));
            $user->name = $request->post('agency_name');
            $user->status = $user::STATUS_NORMAL;
            $user->save();

            $user->assigeRole($this->buyer);

            $buyer = new Buyer();
            $buyer->users_id = $user->id;
            $buyer->account_num = $request->post('account_num',0.00);
            $buyer->mobile = $request->post('mobile');
            $buyer->agency_name = $request->post('agency_name');
            $buyer->agency_id_card = $request->post('agency_id_card');
            $buyer->id_card_front = $request->post('id_card_front');
            $buyer->id_card_receive_side = $request->post('id_card_receive_side');
            $buyer->brought_account = $request->post('brought_account');
            $buyer->brought_bank = $request->post('brought_bank','光大银行');
            $buyer->brought_other_bank = $request->post('brought_other_bank');
            $buyer->status = $buyer::STATUS_NORMAL;
            $buyer->save();
        });

        return $this->formatResponse('创建成功');
    }

    public function buyerInfo(Request $request)
    {
        $buyer = Buyer::whereId($request->post('buyer_id'))->first();
        $user = $buyer->user;
        $buyer = Buyer::buyer($buyer);
        $buyer->username = $user->name;
        $buyer->login_name = $user->mobile;
        return $this->formatResponse('获取成功',$this->successStatus,$buyer);
    }

    public function buyerUpdate(Request $request)
    {
        $buyer = Buyer::whereId($request->post('buyer_id'))->first();
        $user = $buyer->user;
        $buyer->account_num = $request->post('account_num',0.00);
        $buyer->mobile = $request->post('mobile');
        $buyer->agency_name = $request->post('agency_name');
        $buyer->agency_id_card = $request->post('agency_id_card');
        $buyer->id_card_front = $request->post('id_card_front');
        $buyer->id_card_receive_side = $request->post('id_card_receive_side');
        $buyer->brought_account = $request->post('brought_account');
        $buyer->brought_bank = $request->post('brought_bank','光大银行');
        $buyer->brought_other_bank = $request->post('brought_other_bank');
        $buyer->save();

        $user->name = $request->post('username');
        $user->login_name = $request->post('login_name');
        $user->save();
        return $this->formatResponse('修改成功',$this->successStatus);
    }

    public function buyerPasswordReset(Request $request)
    {
        $password = $request->post('password','');
        $user = Buyer::whereId($request->post('buyer_id'))->first()->user;
        if(empty($password)){
            return $this->formatResponse('密码不能为空',$this->errorStatus);
        }
        $user->update(['password' => $password]);
        return $this->formatResponse('修改成功',$this->successStatus);
    }

    public function buyerStatusChange(Request $request)
    {
        $user_id = Auth::id();
        $u_id = Buyer::whereId($request->post('buyer_id'))->pluck('user_id');
        if($user_id == $u_id){
            return $this->formatResponse('自己不能对自己操作哦');
        }

        User::whereId($u_id)->update(['status' => $request->post('status')]);
        Buyer::whereId($request->post('shopeeker_id'))->update(['status' => $request->post('status')]);
        return $this->formatResponse('操作成功');
    }



}