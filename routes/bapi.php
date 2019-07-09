<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1',function (Router $api) {
    $api->group(['namespace'=>'App\Api\V1\Controllers','prefix' => 'b'],function (Router $api){
        $api->group(['prefix' => 'auth'], function(Router $api) {
            $api->post('register', 'BAuthController@register');
            $api->post('login', 'BAuthController@login');
            $api->get('refresh', 'BAuthController@refreshToken');
            $api->post('logout', 'BAuthController@logout');
            $api->patch('update', 'BAuthController@update');

            $api->delete('users/{user}','BAuthController@destroy');

            $api->get('test', 'BAuthController@test');

        });

        $api->post('util/translate', 'UtilController@guzzle');

//        $api->get('auth/me', 'BAuthController@me');
        $api->group(['middleware' =>  ['auth:b-api','jwt.system:b']], function(Router $api) {
            $api->get('auth/me', 'BAuthController@me');
            $api->get('auth/initRoles', 'BAuthController@initRoles');
            $api->get('auth/seeRoleBack', 'BAuthController@seeRoleBack');


            $api->get('protected', function() {
                return response()->json([
                    'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
                ]);
            });

            $api->get('refresh', [
                'middleware' => 'jwt.refresh',
                function() {
                    return response()->json([
                        'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                    ]);
                }
            ]);
        });

        $api->get('hello', function() {
            return response()->json([
                'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
            ]);
        });
    });
});
