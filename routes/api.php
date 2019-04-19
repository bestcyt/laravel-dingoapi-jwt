<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', ['namespace'=>'App\Api\V1\Controllers'],function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('register', 'AuthController@register');
        $api->post('login', 'AuthController@login');
        $api->get('refresh', 'AuthController@refreshToken');
        $api->post('logout', 'AuthController@logout');

        $api->get('test', 'AuthController@test');
        $api->get('me', 'AuthController@me');
    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
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
