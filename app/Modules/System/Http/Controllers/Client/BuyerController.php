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
    /**
     *采购列表
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function buyerList(Request $request)
    {
        $role = Auth::user()->roles->first();
        if($role->id == $this->buyer){
            $buyer = Buyer::whereUsersId(Auth::id())->select('id','account_num','use_account','debt_account_num','buyer_mobile','agency_name','ssl_num_status','status')
                ->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();
        }else{
           // $status = $request->post('status',1);
            $buyer = new Buyer();
            $buyer = $buyer->select('id','account_num','use_account','debt_account_num','buyer_mobile','agency_name','ssl_num_status','status')->orderBy('id','desc')
                            ->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();
        }
        $count = count($buyer);
        foreach ($buyer as &$value){
            $value = Buyer::buyer($value);
        }

        $data = array(
            'buyer' => $buyer,
            'count' => $count
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }

    /**
     * 采购创建
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function buyerCreate(Request $request)
    {
        $user = User::whereMobile($request->post('mobile'))->first();
        if(!is_null($user)){
            return $this->formatResponse('该手机号已注册',$this->errorStatus);
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
            $buyer->use_account = $buyer->account_num;
            $buyer->buyer_mobile = $request->post('buyer_mobile');
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

    /**
     * 采购详情
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function buyerInfo(Request $request)
    {
        $buyer = Buyer::whereId($request->post('buyer_id'))->first();
        $buyer->user;
        $buyer = Buyer::buyer($buyer);

        return $this->formatResponse('获取成功',$this->successStatus,$buyer);
    }

    /**
     * 采购更改
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function buyerUpdate(Request $request)
    {
        $buyer = Buyer::whereId($request->post('buyer_id'))->first();
       // $user = $buyer->user;
        $buyer->account_num = $request->post('account_num',0.00);
      /*  $buyer->buyer_mobile = $request->post('buyer_mobile');
        $buyer->agency_name = $request->post('agency_name');
        $buyer->agency_id_card = $request->post('agency_id_card');
        $buyer->id_card_front = $request->post('id_card_front');
        $buyer->id_card_receive_side = $request->post('id_card_receive_side');
        $buyer->brought_account = $request->post('brought_account');
        $buyer->brought_bank = $request->post('brought_bank','光大银行');
        $buyer->brought_other_bank = $request->post('brought_other_bank');*/
        $buyer->save();

        return $this->formatResponse('修改成功',$this->successStatus);
    }

    /**
     * 密码重置
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function buyerPasswordReset(Request $request)
    {
        $password = $request->post('password','');
        $user = Buyer::whereId($request->post('buyer_id'))->first()->user;
        if(empty($password)){
            return $this->formatResponse('密码不能为空',$this->errorStatus);
        }
        $user->update(['password' => bcrypt($password)]);
        return $this->formatResponse('修改成功',$this->successStatus);
    }

    /**
     * 状态更改
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function buyerStatusChange(Request $request)
    {
        $user_id = Auth::id();
        $u_id = Buyer::whereId($request->post('buyer_id'))->value('users_id');
        if($user_id == $u_id){
            return $this->formatResponse('自己不能对自己操作哦');
        }

        User::whereId($u_id)->update(['status' => $request->post('status')]);
        Buyer::whereId($request->post('buyer_id'))->update(['status' => $request->post('status')]);
        return $this->formatResponse('操作成功');
    }



}