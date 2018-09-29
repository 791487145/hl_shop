<?php
namespace App\Modules\System\Http\Controllers\Client;

use App\Modules\Buyer\Models\Buyer;
use App\Modules\System\Models\BuyerBill;
use App\Modules\System\Models\BuyerBillFile;
use App\Modules\System\Models\BuyerOrder;
use App\Modules\System\Models\BuyerOrderDetail;
use App\Modules\System\Http\Controllers\SystemController;
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
     * 创建合同
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function contractCreate(Request $request)
    {
        $time = Carbon::today();
        $length_days = $time->diffInDays($time->copy()->addMonth($request->post('amortize_time')));

        $buyer = Buyer::whereUsersId(Auth::id())->first();
        if(is_null($buyer)){
            return $this->formatResponse('当前用户不存在，不能操作',$this->errorStatus);
        }
        if($buyer->use_account < $request->post('order_account',0.00)){
            return $this->formatResponse('赊账金额大于可用金额，请重新选择',$this->errorStatus);
        }

        $order_account = $request->post('order_account',0.00);
        $over_cover_charse = $request->post('over_cover_charse',0.00);

        $order = new BuyerOrder();
        $order->buyer_id = $buyer->id;
        $order->amortize_time = $request->post('amortize_time');
        $order->status = BuyerOrder::ORDER_NOT_EFFECT;
        $order->order_account = $order_account;
        $order->cover_charse = bcmul($order_account,($length_days * $this->interest_rate),2);
        $order->over_cover_charse = $over_cover_charse;
        $order->order_total = bcadd(bcadd($order_account,$order->cover_charse,2),$over_cover_charse,2);
        $order->save();

        $order->order_no = date("ymdHis") . sprintf("%03d", substr($order->id, -3));
        $order->save();

        return $this->formatResponse('合同提交成功',$this->successStatus,$order);
    }

    /**
     * 订单提交
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function orderSubmit(Request $request)
    {
        $file_path = $request->post('goods_file');
        if(empty($file_path)){
            return $this->formatResponse('请上传商品清单');
        }

        Excel::selectSheets('Sheet1')->load($file_path, function($reader) use($request) {

            DB::transaction(function () use($request,$reader){
                $order = BuyerOrder::whereOrderNo($request->post('order_no'))->first();

                $data = $reader->noHeading()->all();
                $goods_price = 0;
                unset($data[0]);
                foreach ($data as $value){
                    $order_detail = new BuyerOrderDetail();
                    $order_detail->order_no = $order->order_no;
                    $order_detail->goods_name = $value[0];
                    $order_detail->goods_num = $value[1];
                    $order_detail->goods_price = $value[2];
                    $order_detail->goods_total = $value[3];
                    $order_detail->save();
                    $goods_price = bcadd($goods_price,$value[3],2);
                }

                $order->goods_file = $request->post('goods_file');
                $order->goods_price = bcadd($goods_price,$order->goods_price,2);
                $order->save();
            });
        });

        return $this->formatResponse('订单提交成功，请等待审核',$this->successStatus);
    }

    /**
     * 我的订单
     * @param Request $request
     */
    public function myOrderList(Request $request)
    {
        $buyer = Auth::user()->buyer;
        $buyer_orders = BuyerOrder::whereBuyerId($buyer->id)->forPage($request->post('page',1),$request->post('limit',$this->limit))->orderBy('id','desc')
                                    ->select('id','order_no','buyer_id','order_account','goods_price','order_total','amortize_time','cover_charse','contract','status')
                                    ->get();
        foreach ($buyer_orders as $buyer_order){
            $buyer_order->statusCN = BuyerOrder::statusCN($buyer_order->status);
        }

        $data = array(
            'buyer_orders' => $buyer_orders,
            'count' => count($buyer_orders)
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }

    /**
     * 账单列表
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function myBillList(Request $request)
    {
        $bills = new BuyerBill();
        $status = $request->post('status',$this->pub);
        if($status != $this->pub){
            $bills = $bills->whereStatus($status);
        }

        $bills = $bills->whereBuyerId(Auth::id())->forPage($request->post('page',1),$request->post('limit',$this->limit))->orderBy('id','desc')->get();
        foreach ($bills as $bill){
            $bill->statusCN = BuyerBill::statusCN($bill->status);
            $file = $bill->bill_file->latest()->first();
            if(!is_null($file)){
                $bill->statusCN = BuyerBillFile::statusCN($file->status);
            }
        }

        return $this->formatResponse('获取成功',$this->successStatus,$bills);
    }

    /**
     * 账单详情
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function billInfo(Request $request)
    {
        $bill = BuyerBill::whereId($request->post('bill_id'))->first();
        $user = User::whereId($bill->buyer_id)->fist();
        $bill->name = $user->name;
        $bill->statusCN = BuyerBill::statusCN($bill->status);
        $file = $bill->bill_file->latest()->first();
        if(!is_null($file)){
            $bill->statusCN = BuyerBillFile::statusCN($file->status);
        }

        return $this->formatResponse('获取成功',$this->successStatus,$bill);
    }

    /**
     * 还款申请提交
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function billfileSubmit(Request $request)
    {
        $bill_file = BuyerBillFile::whereBillId($request->post('bill_id'))->whereIn('status',[BuyerBillFile::STATUS_SUCCESS,BuyerBillFile::STATUS_NOT_CHECK])->first();
        if(!is_null($bill_file)){
            return $this->formatResponse('该账单附件已经提交，请勿重复提交',$this->errorStatus);
        }
        $bill_file = new BuyerBillFile();
        $bill_file->user_id = Auth::id();
        $bill_file->status = BuyerBillFile::STATUS_NOT_CHECK;
        $bill_file->content = $request->post('content','');
        $bill_file->bill_id = $request->post('bill_id');
        $bill_file->refund_file = $request->post('refund_file');
        $bill_file->save();

        return $this->formatResponse('提交成功',$this->successStatus);
    }

    /**
     * 服务费列表
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function covercharseList(Request $request)
    {
        $cover_charse = BuyerBill::whereStatus(BuyerBill::STATUS_PAY)->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();
        return $this->formatResponse('获取成功',$this->successStatus,$cover_charse);
    }





}