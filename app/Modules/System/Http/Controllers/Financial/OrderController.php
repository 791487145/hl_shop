<?php
namespace App\Modules\System\Http\Controllers\Financial;

use App\Modules\System\Models\BuyerBill;
use App\Modules\System\Models\BuyerOrder;
use App\Modules\System\Models\BuyerOrderBill;
use App\Modules\System\Models\BuyerOrderDetail;
use App\Modules\System\Http\Controllers\SystemController;
use App\Modules\System\Models\CoverCharse;
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
    /**
     * 订单申请列表
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function orderApply(Request $request)
    {
        $buyer_order_applys = new BuyerOrder();

        $start_time = $request->post('start_time','');
        if(!empty($start_time)){
            $buyer_order_applys = $buyer_order_applys->where('created_at','>',$start_time);
        }

        $end_time = $request->post('end_time','');
        if(!empty($end_time)){
            $buyer_order_applys = $buyer_order_applys->where('created_at','<',$end_time);
        }

        $buyer_order_applys = $buyer_order_applys->whereStatus(BuyerOrder::ORDER_NOT_EFFECT)->orderBy('id','desc')
            ->select('id','order_no','buyer_id','order_account','goods_price','order_total','amortize_time','cover_charse','contract','status')
            ->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();

        foreach ($buyer_order_applys as $buyer_order_apply){
            $user = $buyer_order_apply->buyer()->user;
            $buyer_order_apply->buyer_name = $user->name;
            $buyer_order_apply->status_name = BuyerOrder::statusCN($buyer_order_apply->status);
        }

        return $this->formatResponse('获取成功',$this->successStatus,$buyer_order_applys);
    }

    /**
     * 订单申请详情
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function orderApplyInfo(Request $request)
    {
        $order = BuyerOrder::whereId($request->post('order_id'))->select('id','order_no','buyer_id','order_account','goods_price','order_total','amortize_time','cover_charse','contract','status')->first();
        $order->goods = $order->order_detail()->get();
        if($order->status >= BuyerOrder::ORDER_EFFECT){
            $order->bills = $order->order_bills()->get();
        }

        return $this->formatResponse('获取成功',$this->successStatus,$order);
    }

    /**
     * 操作订单
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
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
                    'amortize_now' => $order->amortize_now + 1
                );
                BuyerOrder::whereId($order->id)->update($param);

                $time = Carbon::today();
                $length_days = $time->diffInDays($time->copy()->addMonth(1));

                $bill = new BuyerBill();
                $bill->order_sn = $order->order_no.'000';
                $bill->cover_charse = bcmul($order->order_account,($length_days * $this->interest_rate),2);
                $bill->month_account = bcadd(bcdiv($order->order_account,$order->amortize_time,2),$bill->cover_charse,2);
                $bill->refund_account = 0.00;
                $bill->status = $bill::STATUS_NOT_PAY;
                $bill->amortize_time = $order->amortize_now + 1;
                $bill->end_time = strtotime($time->copy()->addMonth(1));
                $bill->save();

                $bill->order_sn = bcadd($bill->order_sn + $bill->id);
                $bill->save();

                $order->assigeOrderBill(array($bill->id));

                $cover_charse = new CoverCharse();
                $cover_charse->service_num = $bill->cover_charse;
                $cover_charse->over_service_num = 0.00;
                $cover_charse->save();

                $bill->assignCovercharse(array($cover_charse->id));
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

    /**
     * 全部订单
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function orderList(Request $request)
    {
        $buyer_orders = new BuyerOrder();

        $start_time = $request->post('start_time','');
        if(!empty($start_time)){
            $buyer_orders = $buyer_orders->where('created_at','>',$start_time);
        }

        $end_time = $request->post('end_time','');
        if(!empty($end_time)){
            $buyer_orders = $buyer_orders->where('created_at','<',$end_time);
        }

        $status = $request->post('status',$this->pub);
        if($status != $this->pub){
            $buyer_orders = $buyer_orders->whereStatus($status);
        }

        $buyer_orders = $buyer_orders->orderBy('id','desc')->forPage($request->post('page',1),$request->post('limit',$this->limit))
            ->select('id','order_no','buyer_id','order_account','goods_price','order_total','amortize_time','cover_charse','contract','status')
            ->get();

        foreach ($buyer_orders as $buyer_order){
            $user = $buyer_order->buyer()->user;
            $buyer_order->buyer_name = $user->name;
            $buyer_order->status_name = BuyerOrder::statusCN($buyer_order->status);
        }

        return $this->formatResponse('获取成功',$this->successStatus,$buyer_orders);
    }

    public function orderPaying(Request $request)
    {
        $buyer_orders = new BuyerOrder();

        $start_time = $request->post('start_time','');
        if(!empty($start_time)){
            $buyer_orders = $buyer_orders->where('created_at','>',$start_time);
        }

        $end_time = $request->post('end_time','');
        if(!empty($end_time)){
            $buyer_orders = $buyer_orders->where('created_at','<',$end_time);
        }

        $status = $request->post('status',$this->pub);
        if($status != $this->pub){
            $buyer_orders = $buyer_orders->whereStatus($status);
        }

        $buyer_orders = $buyer_orders->orderBy('id','desc')->forPage($request->post('page',1),$request->post('limit',$this->limit))
            ->select('id','order_no','buyer_id','order_account','goods_price','order_total','amortize_time','cover_charse','contract','status')
            ->get();

        foreach ($buyer_orders as $buyer_order){
            $user = $buyer_order->buyer()->user;
            $buyer_order->buyer_name = $user->name;
            $bill = $buyer_order->order_bills()->where('buyer_bill.amortize_time','=',$buyer_order->amortize_time)->first();
            $bill_file = $bill->bill_file()->orderBy('id','desc')->first();
            $buyer_order->statusCN = BuyerBill::statusCN($bill->status);
            if(!is_null($bill_file)){
                $buyer_order->bill_file = $bill_file->refund_file;
                $buyer_order->bill_file_time = $bill_file->created_at;
                //$buyer_order->
            }
        }
    }







}