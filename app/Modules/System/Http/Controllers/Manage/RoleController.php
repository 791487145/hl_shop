<?php
namespace App\Modules\System\Http\Controllers\Manage;

use App\Modules\System\Http\Controllers\SystemController;
use App\Modules\System\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Log;

class RoleController extends SystemController
{
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

    public function roleInfo(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'role_id' => 'required|integer'
        ],[
            'role_id.required' => '请填写角色id',
            'role_id.integer' => '请输入整数'
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return $this->formatResponse($error[0],$this->errorStatus, $error);
        }

        $role = Role::whereId($request->post('role_id'))->firstOrFail();
        return $this->formatResponse('获取成功',$this->successStatus,$role);
    }

    public function roleUpdate(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'role_id' => 'required|integer'
        ],[
            'role_id.required' => '请填写角色id',
            'role_id.integer' => '请输入整数'
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return $this->formatResponse($error[0],$this->errorStatus, $error);
        }

        $role_id = $data['role_id'];
        unset($data['role_id']);
        if(!empty($data)){
            Role::whereId($role_id)->update($data);
        }

        return $this->formatResponse('修改成功',$this->successStatus);
    }

    public function roleDelete(Request $request)
    {
        $data = $request->post('role_id');
        return $this->formatResponse('获取成功',$this->successStatus,$data);
       /* $role = Role::whereId($request->post('role_id'))->firstOrFail();
        $user_role = $role->role_user;
        if(!$user_role->isEmpty()){
            return $this->formatResponse('该角色下有多个账号，不能删除',$this->errorStatus);
        }

        $role->destroy($request->post('role_id'));
        return $this->formatResponse('删除成功');*/
    }

}