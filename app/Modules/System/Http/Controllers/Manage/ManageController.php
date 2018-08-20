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
        $users = User::whereStatus(User::STATUS_NORMAL)->select('id','name','email','created_at')->get();
        foreach ($users as $user){
            $role = $user->roles()->where('user_role.role_id','>=',3)->first();
            $user->role = isset($role->name) ? $role->name : '请设置权限';
        }
        return $this->formatResponse('获取成功',$this->successStatus,$users);
    }

    public function userCreate(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'name' => 'required',
            'email' => 'required|email|unique:user',
            'password' => 'required',
        ],[
            'name.required' => '请填写用户名',
            'email.required' => '请添加登录名',
            'email.email' => '格式不正确',
            'email.unique' => '该账号已注册',
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
        $user->role_id = $user->roles()->pluck('id');
        $roles = Role::get();

        $data = array(
            'user' => $user,
            'roles' => $roles
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }

    public function userUpdate(Request $request)
    {
        $name = $request->post('name');
        $email = $request->post('email');
        User::whereId($request->post('user_id'))->update(['name' => $name,'email' => $email]);
        return $this->formatResponse('修改成功');
    }

    public function userDelete(Request $request)
    {
        $user = User::whereId($request->post('user_id'))->first();
        $role = $user->roles()->first();
        if($role->id == Role::ROLE_ADMIN){
            return $this->formatResponse('无权限删除超级管理员');
        }

        $user->deleteRole($role);
        User::distory($request->post('user_id'));
        return $this->formatResponse('删除成功');
    }

    public function passwordReset(Request $request)
    {
        $user = Auth::user();
        if($user->password != bcrypt($request->post('old_password'))){
            return $this->formatResponse('原密码不正确');
        }
        $user->update(['password' => $request->post('new_password')]);
        return $this->formatResponse('修改成功');
    }



}