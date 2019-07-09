<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\LoginRequest;
use App\Api\V1\Requests\SignUpRequest;
use App\Jobs\b\initBRolesAndPermission;
use App\Models\BUser;
use App\Traits\TranslateTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\JWTAuth;
use App\User;

class UtilController extends BaseController
{
    use TranslateTrait;
    public function __construct()
    {
        //@todo 用户认证方法过滤
//        $this->middleware('auth:api',['except'=>['register','login','test','destroy']]);
    }

    public function testTranslate(Request $request){

        return [$this->translate($request->input('name'),'en')];
    }

    public function guzzle(){
        $url = 'http://translate.google.cn/translate_a/single?client=gtx&dt=t&dj=1&ie=UTF-8&sl=auto&tl=en-hk&q=测试';
        $client = new Client();
        $response = $client->request('GET', $url);        echo  $response->getBody();
    }

}
