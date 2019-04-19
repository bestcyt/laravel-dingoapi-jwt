<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\LoginRequest;
use App\Api\V1\Requests\SignUpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\JWTAuth;
use App\User;

class AuthController extends BaseController
{
    public function __construct()
    {
        //@todo 用户认证方法过滤
        $this->middleware('auth:api',['except'=>['register','login','test']]);
    }

    public function register(SignUpRequest $request,JWTAuth $JWTAuth)
    {
        //@todo 创建用户，返回token
        try{
            $user = User::create($request->all());
        }catch(\Exception $exception){
            Log::error('create user error in '.now());
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
        $token = $JWTAuth->attempt($checkUser);
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

    public function me()
    {
        $user = auth()->user();

        

        return $this->ok($user);
    }

    public function test()
    {
        return $this->ok('test ok');
    }


}
