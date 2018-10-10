<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

#获取授权码路由
Route::post('authentication', 'Api\TonkenController@index');

#只有授权成功的用户才能访问的路由
Route::namespace('Api')->middleware('api','auth:api')->group( function () {
    #获取当前用户的信息
    Route::get('user', function (Request $request) {
        $menu = [
            [
                'path' => '/personal',
                'name'  => 'personal',
                'component' => 'personal',
                'meta'  => [
                    'title' => '个人中心',
                ]
            ],
            [
                'path' => '/ruanwen',
                'name'  => 'ruanwen',
                'component' => 'ruanwen',
                'meta'  => [
                    'title' => '软文中心',
                ]
            ],
            [
                'path'  => '/orders',
                'name'  => 'orders',
                'component' => 'orders',
                'meta'  => [
                    'title' => '订单中心'
                ]
            ],
        ];
        $respond = array_merge($request->user()->toArray(), [ 'routers' => $menu]);
        //return $request->user();
        return $respond;
    });

    Route::get('orders', function () {
        $str = 'QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm';

        $arr = [];
        for($i = 0;$i<40;$i++) {
            $arr[$i] = [
                'id'    => rand(1,100),
                'title' => substr(str_shuffle($str),0,30),
                'media' => '凤凰厦门',
                'url'   => 'http://www.baidu.com',
                'price' => 40,
                'created_at' => '2018-08-26 06:24:23',
                'updated_at' => '2018-08-26 06:24:23',
                'status'    => 1
            ];
        }
        return $arr;
    });


});


Route::post('/register','Api\RegisterController@index');
