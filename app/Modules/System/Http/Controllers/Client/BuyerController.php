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


        }else{

        }

        return $this->formatResponse('获取成功',$this->successStatus);
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



}