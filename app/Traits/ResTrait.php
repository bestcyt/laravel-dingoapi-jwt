<?php

namespace App\Traits;

trait ResTrait
{

    public function ok($data , $code = 200)
    {
        $res['code'] = $code;
        if (!empty($data)){
            $res['data'] = $data;
        }
        return response()->json($res);
    }

    public function error($msg = '失败',$code = 500)
    {
        return response()->json([
            'code' => $code,
            'msg'  => $msg,
        ]);
    }


    public function responseWithToken($token){
        if (empty($token)){
            return $this->error('缺少token');
        }

        return $this->ok([
            'token'=>$token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}