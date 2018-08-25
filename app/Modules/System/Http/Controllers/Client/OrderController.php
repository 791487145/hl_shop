<?php
namespace App\Modules\System\Http\Controllers\Client;

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

    public function myOrderList(Request $request)
    {
        BuyerOrder::whereBuyerId(Auth::id())->orderBy("id",'desc')->get();
    }



}