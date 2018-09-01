<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Api\Traits\ApiResponseTraits;

class TonkenController extends Controller
{
    use AuthenticatesUsers,ApiResponseTraits;
    
    public function index(Request $request)
    {   
        #数据验证
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return $this->failed( $validator->errors()->toArray() );
        }

        #开始登录
        filter_var($request->username,FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $request->username :
            $credentials['phone'] = $request->username;
        
        $credentials['password'] = $request->password;

        if( !$this->guard('api')->attempt($credentials) ) {
            return $this->failed('用户名或密码错误');
        } 

        return $this->authenticate($request);
        
    }

    #调用认证接口获取授权码
    protected function authenticate(Request $request)
    {
        $request->request->add([
            'grant_type'    => env('OAUTH_GRANT_TYPE'),
            'client_id'     => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_CLIENT_SECRET'),
            'scope'         => env('OAUTH_SCOPE'),
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = \Route::dispatch($proxy);

        return $response;
    }

    #登录数据验证
    protected function validator(Request $request)
    {
        return \Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|between:6,32',
        ],[
            'username.required' => '请输入登录账号',
            'password.required' => '请输入密码',
            'password.between' => '密码长度必须是6-32个字符之间',
        ]);
    }

}
