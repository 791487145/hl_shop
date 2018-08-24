<?php
namespace App\Modules\System\Http\Controllers\Client;

use App\Models\BuyerOrder;
use App\Modules\System\Http\Controllers\SystemController;
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
        $order = new BuyerOrder();
        $order->buyer_id = Auth::id();
        $order->amortize_time = $request->post('amortize_time');
        $order->status = $order::ORDER_NOT_EFFECT;
        $order->order_account = $request->post('order_account',0);
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


                $data = $reader->all();
                foreach ($data as $value){
                    //$order
                }
            });
        });

    }



}