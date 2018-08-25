<?php
namespace App\Modules\System\Http\Controllers\Financial;

use App\Modules\System\Models\BuyerOrder;
use App\Modules\System\Models\BuyerOrderDetail;
use App\Modules\System\Http\Controllers\SystemController;
use App\Modules\System\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;
use DB;
use Storage;
use Excel;


class OrderController extends SystemController
{
    public function orderApply(Request $request)
    {
        $buyer_order_applys = BuyerOrder::whereStatus(BuyerOrder::ORDER_NOT_EFFECT)->orderBy('id','desc')
            ->select('id','order_no','buyer_id','order_account','goods_price','order_total','amortize_time','cover_charse','contract','status')
            ->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();

        foreach ($buyer_order_applys as $buyer_order_apply){
            $user = $buyer_order_apply->buyer()->user;
            $buyer_order_apply->buyer_name = $user->name;
            $buyer_order_apply->status_name = BuyerOrder::statusCN($buyer_order_apply->status);
        }

        return $this->formatResponse('获取成功',$this->successStatus,$buyer_order_applys);
    }

    public function orderApplyInfo(Request $request)
    {
        $order = BuyerOrder::whereId($request->post('order_id'))->select('id','order_no','buyer_id','order_account','goods_price','order_total','amortize_time','cover_charse','contract','status')->first();
        $order->goods = $order->order_detail()->get();

        return $this->formatResponse('获取成功',$this->successStatus,$order);
    }


    public function orderStatusChange(Request $request)
    {
        $status = $request->post('status',BuyerOrder::ORDER_EFFECT);
        $order_id = $request->post('order_id','');
        if(empty($order_id)){
            return $this->formatResponse('订单id不能为空',$this->errorStatus);
        }

        $order = BuyerOrder::whereId($order_id)->first();
        $user = $order->buyer()->user();
        if($status == BuyerOrder::ORDER_EFFECT){
            DB::transaction(function () use($request,$order){

                $param = array(
                    'status' => BuyerOrder::ORDER_EFFECT,
                    'effective_time' => strtotime(Carbon::now()),
                    'effective_end_time' => strtotime(Carbon::now()->addMonth($order->amortize_time)),
                );
                BuyerOrder::whereId($order->id)->update($param);

                //$order_bill = new Buyer


            });
        }

        if($status == BuyerOrder::ORDER_REFUSE){
            $message = new Message();
            $message->from_id = Auth::id();
            $message->to_id = $user->id;
            $message->status = $message::STATUS_NO_READ;
            $message->content = '您的订单被拒绝，请重新下单';
            $message->ide = $message::IDE_ORDER;
            $message->save();
        }

        return $this->formatResponse('操作成功',$this->successStatus);
    }





}