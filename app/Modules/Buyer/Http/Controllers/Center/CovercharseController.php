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

class CovercharseController extends BuyerController
{
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