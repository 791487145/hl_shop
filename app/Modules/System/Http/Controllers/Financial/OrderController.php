<?php
namespace App\Modules\System\Http\Controllers\Financial;

use App\Modules\Buyer\Models\Buyer;
use App\Modules\System\Models\BuyerBill;
use App\Modules\System\Models\BuyerBillFile;
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
            $user = $buyer_order_apply->buyer()->first()->user()->first();
            $buyer_order_apply->buyer_name = $user->name;
            $buyer_order_apply->status_name = BuyerOrder::statusCN($buyer_order_apply->status);
        }
        $count = count($buyer_order_applys);

        $data = array(
            'count' => $count,
            'buyer_order_applys' => $buyer_order_applys
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
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
        $order->status_name = BuyerOrder::statusCN($order->status);
        if($order->status >= BuyerOrder::ORDER_EFFECT){

            $meds = $order->order_bill_med()->get();
            $param =array();
            foreach ($meds as $med){
                $param[] = $med->bills()->first();
            }
            $order->bills = $param;

            foreach ($order->bills as $val){
                $val->statusCN = BuyerBill::statusCN($val->status);
            }
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
        $buyer = $order->buyer()->first();

        if($buyer->use_account < $order->order_account){
            return $this->formatResponse('操作失败，赊账金额超过总额度',$this->errorStatus);
        }

        $user = $buyer->user()->first();

        if($status == BuyerOrder::ORDER_EFFECT){//生效
            DB::transaction(function () use($request,$order,$buyer){

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
                $bill->buyer_id = $order->buyer_id;
                $bill->save();

                $bill->order_sn = bcadd($bill->order_sn,$bill->id);
                $bill->save();

                $param2 =array(
                    'order_no' => $order->order_no,
                    'order_sn' => $bill->order_sn
                );
                BuyerOrderBill::insert($param2);

                $cover_charse = new CoverCharse();
                $cover_charse->service_num = $bill->cover_charse;
                $cover_charse->over_service_num = 0.00;
                $cover_charse->save();

                $bill->assignCovercharse(array($cover_charse->id));

                $param1 = array(
                    'use_account' => bcsub($buyer->account_num,$order->order_account,2),
                    'debt_account_num' => $order->order_account,
                    'refund_account_num' => bcadd($order->order_account,$order->cover_charse,2)
                );
                Buyer::whereId($buyer->id)->update($param1);
            });
        }

        if($status == BuyerOrder::ORDER_REFUSE){//被拒
            $message = new Message();
            $message->from_id = Auth::id();
            $message->to_id = $user->id;
            $message->status = $message::STATUS_NO_READ;
            $message->content = '您的订单被拒绝，请重新下单';
            $message->ide = $message::IDE_ORDER;
            $message->save();

            BuyerOrder::whereId($order_id)->update(['status' => BuyerOrder::ORDER_REFUSE]);
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

        $order_no = $request->post('order_no','');
        if(!empty($order_no)){
            $buyer_orders = $buyer_orders->whereOrderNo($order_no);
        }

        $buyer_orders = $buyer_orders->orderBy('id','desc')->forPage($request->post('page',1),$request->post('limit',$this->limit))
            ->select('id','order_no','buyer_id','order_account','goods_price','order_total','amortize_time','cover_charse','contract','status','created_at')
            ->get();

        foreach ($buyer_orders as $buyer_order){
            $user = $buyer_order->buyer()->first()->user()->first();
            $buyer_order->buyer_name = $user->name;
            $buyer_order->status_name = BuyerOrder::statusCN($buyer_order->status);
        }

        $data = array(
            'count' => count($buyer_orders),
            'buyer_orders' => $buyer_orders
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }

    /**
     * 未还款账单
     * @param Request $request
     */
    public function orderPaying(Request $request)
    {
        $bills  = new BuyerBill();

        $start_time = $request->post('start_time','');
        if(!empty($start_time)){
            $bills = $bills->where('created_at','>',$start_time);
        }

        $end_time = $request->post('end_time','');
        if(!empty($end_time)){
            $bills = $bills->where('created_at','<',$end_time);
        }

        $order_sn = $request->post('order_sn','');
        if(!empty($order_sn)){
            $bills = $bills->whereOrderSn($order_sn);
        }

        $bills = $bills->whereIn('status',[0,2])->orderBy('id','desc')->forPage($request->post('page',1),$request->post('limit',$this->limit))
                        ->select('id','order_sn','amortize_time','month_account','refund_account','over_cover_charse','cover_charse','status','end_time')
                        ->get();

        foreach ($bills as $bill) {
            $bill->statusCN = BuyerBill::statusCN($bill->status);
            $order = $bill->order_bill_med()->first()->orders()->first();
            $user = $order->buyer()->first()->user()->first();
            $bill->buyer_name = $user->name;
            $bill->order_no = $order->order_no;
            $bill_file = $bill->bill_file()->latest()->first();
            if(!is_null($bill_file)){
                $bill->file_statusCN = BuyerBillFile::statusCN($bill_file->status);
            }else{
                $bill->file_statusCN = '未提交申请';
            }
            if($order->status >= BuyerOrder::ORDER_REFUND){
                $bill->statusCN = BuyerOrder::statusCN($order->status);
            }
        }

        $data = array(
            'count' => count($bills),
            'bills' => $bills
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }


    /**
     * 更改账单状态
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function billStatusChange(Request $request)
    {
        $status = $request->post('status',BuyerBill::STATUS_PAY);

        $order_sn = $request->post('order_sn','');
        if(empty($order_sn)){
            return $this->formatResponse('还款单号不能为空',$this->errorStatus);
        }

        $bill = BuyerBill::whereOrderSn($order_sn)->first();
        $order = $bill->order_bill_med()->first()->orders()->first();
        $bill_file = $bill->bill_file()->latest()->first();

        $buyer = $order->buyer()->first();

        if($order->status >= BuyerOrder::ORDER_END){
            return $this->formatResponse('当前订单已结束，无法操作',$this->errorStatus);
        }
        if(is_null($bill_file) || $bill_file->status == BuyerBillFile::STATUS_FAIL_CHECK || $bill_file->status == BuyerBillFile::STATUS_NOT_CHECK){
            return $this->formatResponse('请先提交还款资料或等待审核',$this->errorStatus);
        }
        if($bill->status != BuyerBill::STATUS_NOT_PAY && $bill->status != BuyerBill::STATUS_OVER_NOT_PAY){
            return $this->formatResponse('当前账单已还清,请勿重复操作',$this->errorStatus);
        }

        if($status == BuyerBill::STATUS_PAY){
            BuyerBill::whereOrderSn($order_sn)->update(['status'=>$status,'refund_account'=>$bill->month_account]);
            BuyerBillFile::whereId($bill_file->id)->update(['status' => BuyerBillFile::STATUS_SUCCESS]);
            if($bill->amortize_time == $order->amortize_time){
                BuyerOrder::whereId($order->id)->update(['has_payment' => bcadd($bill->month_account,$order->has_payment,2),'status'=> BuyerOrder::ORDER_END]);
            }else{
                BuyerOrder::whereId($order->id)->update(['has_payment' => bcadd($bill->month_account,$order->has_payment,2)]);
            }

            $parm = array(
                'use_account' => bcadd($buyer->use_account,bcsub($bill->month_account,$bill->cover_charse,2),2),
                'debt_account_num' => bcsub($buyer->debt_account_num,$bill->month_account,2),
                'refund_account_num' => bcsub($buyer->refund_account_num,$bill->month_account,2)
            );
            Buyer::whereId($buyer->id)->update($parm);
        }else{
            return $this->formatResponse('无效参数',$this->errorStatus);
        }

        return $this->formatResponse('操作成功',$this->successStatus);
    }









}