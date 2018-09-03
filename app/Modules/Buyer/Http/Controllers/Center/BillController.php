<?php
namespace App\Modules\Buyer\Http\Controllers\Center;

use App\Http\Controllers\ApiController;
use App\Modules\Buyer\Http\Controllers\BuyerController;
use App\Modules\Shopeeker\Http\Controllers\ShopeekerController;
use App\Modules\System\Models\AuthMenu;
use App\Modules\System\Models\BuyerBill;
use App\Modules\System\Models\BuyerBillFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class BillController extends BuyerController
{
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

        $start_time = $request->post('start_time','');
        if(!empty($start_time)){
            $bills = $bills->where('created_at','>',$start_time);
        }

        $end_time = $request->post('end_time','');
        if(!empty($end_time)){
            $bills = $bills->where('created_at','<',$end_time);
        }
        
        $buyer = Auth::user()->buyer()->first();

        $bills = $bills->whereBuyerId($buyer->id)->forPage($request->post('page',1),$request->post('limit',$this->limit))->orderBy('id','desc')->get();
        foreach ($bills as $bill){
            $bill->statusCN = BuyerBill::statusCN($bill->status);
            $file = $bill->bill_file()->latest()->first();
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
        $user = User::whereId($bill->buyer_id)->first();
        $bill->name = $user->name;
        $bill->statusCN = BuyerBill::statusCN($bill->status);
        $file = $bill->bill_file()->latest()->first();
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

}