<?php
namespace App\Modules\System\Http\Controllers\Manage;

use App\Modules\System\Http\Controllers\SystemController;
use App\Modules\System\Models\AuthMenu;
use App\Modules\System\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Validator;
use Log;
use DB;

class ManageController extends SystemController
{

    public function userList(Request $request)
    {
        $users = User::whereStatus(User::STATUS_NORMAL)->select('id','name','mobile','created_at')->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();
        $count = User::whereStatus(User::STATUS_NORMAL)->count();
        foreach ($users as $user){
            $role = $user->roles()->where('user_role.role_id','>=',3)->first();
            $user->role = isset($role->name) ? $role->name : '请设置权限';
        }
        $users->count = $count;
        
        return $this->formatResponse('获取成功',$this->successStatus,$users);
    }

    public function userCreate(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'name' => 'required',
            'mobile' => 'required|unique:users',
            'password' => 'required',
        ],[
            'name.required' => '请填写用户名',
            'mobile.required' => '请添加登录名',
            'mobile.unique' => '该账号已注册',
            'password.required' => '请输入密码',
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return $this->formatResponse($error[0],$this->errorStatus, $error);
        }
        
        $data['password'] = bcrypt($data['password']);
        DB::transaction(function () use($data,$request){
            $user = User::create($data);
            $user->assigeRole($request->post('role_id'));
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;
        });
        return $this->formatResponse('添加成功');
    }

    public function userInfo(Request $request)
    {
        $user = User::whereId($request->post('user_id'))->first();
        $role = $user->roles()->first();
        $user->role_id = 0;
        if(!is_null($role)){
            $user->role_id = $role->id;
        }

        $roles = Role::select('id','name')->get();

        $data = array(
            'user' => $user,
            'roles' => $roles
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }

    public function userUpdate(Request $request)
    {
        $name = $request->post('name');
        $mobile = $request->post('mobile');
        $role_id = $request->post('role_id',0);
        User::whereId($request->post('user_id'))->update(['name' => $name,'mobile' => $mobile]);
        if($role_id == $this->shopeeker || $role_id == $this->buyer){
            return $this->formatResponse('采购或供应商角色只能在相关菜单下操作');
        }

        if(!is_null($role_id)){
            User::whereId($request->post('user_id'))->first()->assigeRole($role_id);
        }
        return $this->formatResponse('修改成功');
    }

    public function userDelete(Request $request)
    {
        $user = User::whereId($request->post('user_id'))->first();
        if(is_null($user)){
            return $this->formatResponse('该用户不存在');
        }
        $role = $user->roles->first();

        if(!is_null($role) && $role->id == Role::ROLE_ADMIN){
            return $this->formatResponse('无权限删除超级管理员');
        }

        $user->deleteRole($role);
        User::destroy($request->post('user_id'));
        return $this->formatResponse('删除成功');
    }

    public function passwordReset(Request $request)
    {
        $user = User::whereId($request->post('user_id'))->first();
        $role = $user->roles->first();
        if(!is_null($role)){
            $u = Auth::user();
            if($role->id == $this->admin && $u->id != $user->id){
                return $this->formatResponse('超级管理员密码只能自己修改',$this->errorStatus);
            }
        }

        $user->update(['password' => bcrypt($request->post('new_password'))]);
        return $this->formatResponse('修改成功');
    }



}