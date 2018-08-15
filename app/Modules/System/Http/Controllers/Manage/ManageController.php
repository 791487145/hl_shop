<?php
namespace App\Modules\System\Http\Controllers\Manage;

use App\Modules\System\Http\Controllers\SystemController;
use App\Modules\System\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class ManageController extends SystemController
{
    public function systemList(Request $request,User $user)
    {
        return $this->formatResponse('nihao');
    }


    public function roleList(Request $request,Role $role)
    {
        $roles = Role::orderBy('order', 'desc')->get();
        return $this->formatResponse('获取成功',$this->successStatus,$roles);
    }

    public function roleCreate(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'name' => 'required|unique:role',
            'order' => 'required|integer|min:1',
        ],[
            'name.required' => '请填写角色名',
            'name.unique' => '该角色名已存在',
            'order.integer' => '请输入整数',
            'order.min' => '最小值为1',
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return $this->formatResponse($error[0],$this->errorStatus, $error);
        }

        $role = new Role();
        $role->name = $data['name'];
        $role->description = $data['description'];
        $role->order = isset($data['order']) ? $data['order'] : 1;
        $role->save();

        return $this->formatResponse('添加成功');
    }

    public function roleUpdate(Request $request)
    {

    }

}