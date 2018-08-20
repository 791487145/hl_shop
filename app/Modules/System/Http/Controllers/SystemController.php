<?php
namespace App\Modules\System\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Modules\System\Models\AuthMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class SystemController extends ApiController
{
    public $name;
    public function __construct(Route $route)
    {
        /*$name = $route->getName();
        $permission = AuthMenu::whereName($name)->firstOrFail();

        $ret = Auth::user()->hasPermission($permission);
        dd($ret);*/
    }

}