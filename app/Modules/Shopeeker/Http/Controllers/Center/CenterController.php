<?php
namespace App\Modules\Shopeeker\Http\Controllers\Center;

use App\Http\Controllers\ApiController;
use App\Modules\Shopeeker\Http\Controllers\ShopeekerController;
use App\Modules\System\Models\AuthMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;
use Illuminate\Auth\EloquentUserProvider;
use Hash;

class CenterController extends ShopeekerController
{
    public function passwordReset(Request $request)
    {
        $user = Auth::user();

        if(!Hash::check($request->post('old_password'), $user->password)){
            return $this->formatResponse('原始密码不正确，请重新输入');
        };

        $user->update(['password' => bcrypt($request->post('new_password'))]);
        return $this->formatResponse('修改成功');
    }

    public function contractList(Request $request)
    {
        $user = Auth::user();
        $data = array(
            'contract_use' => $user['contract_use'],
            'contract_sale' => $user['contract_sale']
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }

}