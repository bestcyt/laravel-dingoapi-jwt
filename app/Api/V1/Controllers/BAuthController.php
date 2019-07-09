<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\LoginRequest;
use App\Api\V1\Requests\SignUpRequest;
use App\Jobs\b\initBRolesAndPermission;
use App\Models\BUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\JWTAuth;
use App\User;

class BAuthController extends BaseController
{
    public function __construct()
    {
        //@todo 用户认证方法过滤
//        $this->middleware('auth:api',['except'=>['register','login','test','destroy']]);
    }

    public function register(SignUpRequest $request,JWTAuth $JWTAuth)
    {
        //@todo 创建用户，返回token
        try{
            $user = BUser::create($request->all());
        }catch(\Exception $exception){
            Log::error('createBuser error in '.now());
        }

        if (!$user){
            return $this->error('创建用户失败');
        }

        $token = $JWTAuth->fromUser($user);

        return $this->responseWithToken($token);
    }

    public function login(LoginRequest $request,JWTAuth $JWTAuth)
    {
        //@todo 获取信息验证，返回token


        $checkUser = $request->only(['email','password','name']);
        $user = BUser::where([
            ['email','=',$checkUser['email']],
            ['password','=',$checkUser['password']],
            ['name','=',$checkUser['name']],
        ])->first();
        $token = $JWTAuth->fromUser($user);
        if (!$token){
            return $this->error('用户信息不匹配');
        }
        return $this->responseWithToken($token);
    }

    public function logout()
    {
        //@todo auth登出
        auth()->logout();
        return $this->ok('退出成功');
    }

    public function refreshToken()
    {
        //@todo 刷新token
        return $this->responseWithToken(auth()->refresh());
    }

    public function seeRoleBack(){
        $role = Role::create(['guard_name' => 'a-api', 'name' => 'test_role']);

        return $this->ok($role);
    }

    public function me()
    {
        $user = auth()->guard('b-api')->getPayload();

        return $this->ok([$user]);
    }

    public function initRoles(){
        initBRolesAndPermission::dispatch();
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        try{
            $res = $user->update($request->only(['name']));
        }catch (\Exception $exception){
            Log::info('更新失败');
        }
        if ($res){
            return $this->ok('更新成功');
        }
        return $this->error('更新失败');
    }

    public function destroy($userId)
    {
        $user =Buser::find($userId);
        $res = $user->delete();
        if ($res){
            return $this->ok('删除成功');
        }
        return $this->error('删除失败');
    }


    public function test()
    {
        return $this->ok('test ok');
    }


}
