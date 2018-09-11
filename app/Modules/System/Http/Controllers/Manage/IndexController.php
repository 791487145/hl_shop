<?php
namespace App\Modules\System\Http\Controllers\Manage;

use App\Modules\System\Http\Controllers\ShopeekerController;
use App\Modules\System\Http\Controllers\SystemController;
use App\Modules\System\Models\AuthMenu;
use App\Modules\System\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Log;

class IndexController extends SystemController
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $menu = $user->roles()->first()->permissions->where('tier','<',2)->sortBy('order')->toArray();
       
        $menus = \Common::listToTree($menu,'id','parent_id');

        return $this->formatResponse('获取成功',$this->successStatus,$menus);
    }



}