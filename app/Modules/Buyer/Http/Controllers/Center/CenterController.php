<?php
namespace App\Modules\Buyer\Http\Controllers\Center;

use App\Http\Controllers\ApiController;
use App\Modules\Buyer\Http\Controllers\BuyerController;
use App\Modules\Shopeeker\Http\Controllers\ShopeekerController;
use App\Modules\System\Models\AuthMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class CenterController extends BuyerController
{
    public function center(Request $request)
    {
        $buyer = Auth::user()->buyer();
        return $this->formatResponse('获取成功',$this->successStatus,$buyer);
    }

}