<?php
namespace App\Modules\System\Http\Controllers\Client;

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

        $order = new BuyerOrder();
        $order->buyer_id = Auth::id();
        $order->amortize_time = $request->post('amortize_time');
        $order->status = $order::ORDER_NOT_EFFECT;
        $order->order_account = $request->post('order_account',0.00);
        $order->cover_charse = bcmul($order->order_account,($length_days * $this->interest_rate),2);
        $order->over_cover_charse = $request->post('over_cover_charse',0.00);
        $order->order_total = bcadd(bcadd($order->order_account,$order->cover_charse,2),$order->over_cover_charse,2);
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
                $order->goods_file = $request->post('goods_file');
                $order->save();

                $data = $reader->all();
                foreach ($data as $value){
                    $order_detail = new BuyerOrderDetail();
                    $order_detail->order_no = $order->order_no;
                    $order_detail->goods_name = $value[0];
                    $order_detail->goods_num = $value[1];
                    $order_detail->goods_price = $value[2];
                    $order_detail->goods_total = $value[3];
                    $order_detail->save();
                }
            });
        });

        return $this->formatResponse('订单提交成功，请等待审核',$this->successStatus);
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
        $bill_file->save();

        return $this->formatResponse('提交成功',$this->successStatus);
    }

    public function covercharseList(Request $request)
    {

    }





}