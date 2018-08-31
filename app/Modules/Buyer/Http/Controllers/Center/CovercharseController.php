<?php
namespace App\Modules\Buyer\Http\Controllers\Center;

use App\Http\Controllers\ApiController;
use App\Modules\Buyer\Http\Controllers\BuyerController;
use App\Modules\Shopeeker\Http\Controllers\ShopeekerController;
use App\Modules\System\Models\AuthMenu;
use App\Modules\System\Models\BuyerBill;
use App\Modules\System\Models\BuyerBillFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class CovercharseController extends BuyerController
{
    /**
     * 服务费列表
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function covercharseList(Request $request)
    {
        $month = $request->post('month',$this->pub);

        $cover_charse = new BuyerBill();
        if($month != $this->pub){
            $start_time = Carbon::create(null,$month,1,0,0,0);
            $end_time = $start_time->addMonth(1);
            $cover_charse = $cover_charse->where('end_time','>=',strtotime($start_time))->where('end_time','<',strtotime($end_time));
            $cover_charse_amount = BuyerBill::where('end_time','>=',strtotime($start_time))->where('end_time','<',strtotime($end_time))->whereStatus(BuyerBill::STATUS_PAY)->sum('cover_charse');
        }else{
            $cover_charse_amount = BuyerBill::whereStatus(BuyerBill::STATUS_PAY)->sum('cover_charse');
        }

        $cover_charse = $cover_charse->whereStatus(BuyerBill::STATUS_PAY)->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();


        $buyer = Auth::user()->buyer()->first();
       
        $data = array(
            'cover_charse' => $cover_charse,
            'user_account' => bcsub($buyer->account_num,$buyer->use_account,2),
            'cover_charse_amount' => $cover_charse_amount
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }

}