<?php
namespace App\Modules\System\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Modules\System\Models\AuthMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Route;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class SystemController extends ApiController
{

    public function __construct()
    {
       /* $this->middleware(function ($request, $next) {
            $name = Route::currentRouteName();
            if(Auth::user()->cannot($name)){
                return $this->formatResponse('您没有该动作权限',$this->unauthized);
            };
            return $next($request);
        });*/
    }

}