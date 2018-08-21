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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
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
        $role->description = isset($data['description']) ? $data['description'] : '';
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

        if($data['role_id'] <= 3 ){
            return $this->formatResponse('暂时没有权限');
        }

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
        $role = Role::whereId($request->post('role_id'))->firstOrFail();
        $user_role = $role->role_user;
        if(!$user_role->isEmpty()){
            return $this->formatResponse('该角色下有多个账号，不能删除',$this->errorStatus);
        }

        if($role->id <= 3 ){
            return $this->formatResponse('暂时没有权限');
        }

        $role->destroy($request->post('role_id'));
        return $this->formatResponse('删除成功');
    }

    public function assignPermission(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'role_id' => 'required|integer',
            'permissions' => 'required|array',
        ],[
            'role_id.required' => 'role_id参数短缺',
            'role_id.integer' => '请输入整数',
            'permissions.required' => 'permissions参数短缺',
            'permissions.array' => 'permissions格式为数组',
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return $this->formatResponse($error[0],$this->errorStatus, $error);
        }

        $role = Role::whereId($request->post('role_id'))->first();

        $role->assigePermission($request->post('permissions'));
        return $this->formatResponse('添加成功');
    }

    public function permissionList(Request $request)
    {
        $permissions = AuthMenu::select('id','title','parent_id')->get()->toArray();
        $role = Role::whereId($request->post('role_id'))->first();
        $permissions_id = $role->permissions()->pluck('auth_menu.id');
        $permissions = \Common::listToTree($permissions,'id','parent_id');

        $data = array(
            'permissions' => $permissions,
            'permissions_id' => $permissions_id,
            'permissions' => $permissions
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }

}