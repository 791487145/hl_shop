<?php
namespace App\Modules\System\Http\Controllers\Manage;

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

class PermissionController extends SystemController
{


    public function permissionCreate(Request $request)
    {
        $permission = new AuthMenu();
        $permission->name = $request->post('name');
        $permission->parent_id = $request->post('parent_id');
        $permission->order = $request->post('order',1);
        $permission->title = $request->post('title');
        $permission->save();

        return $this->formatResponse('添加成功');
    }

}