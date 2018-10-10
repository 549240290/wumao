<?php
/**
* 
*   API 接口返回 Traits
*
*   HTTP 响应格式
*
*   return [
*      'status'    => 'success or fail',
*      'code'      => '200 or 400 or 403 or 500 or other',
*      'msg'       => '请求成功 or 请求失败 or 错误提示等',
*      'data'      => ' array '
*   ]
*
**/
namespace App\Http\Controllers\Api\Traits;

use Response;

trait ApiResponseTraits
{
    protected $statusCode = 200;

    # 设置 HTTP 状态码方法
    protected function setStatusCode( $code )
    {
        $this->statusCode = $code;
        return $this;
    }

    # 获取 HTTP 状态码方法
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    # 发送响应
    protected function respond( $data, $status = 'success', $header = [])
    {
        $status_and_code = [
            'status'    =>  $status,
            'code'      =>  $this->getStatusCode()
        ];
        $data = array_merge($status_and_code,$data);
        return Response::json( $data, $this->getStatusCode(),$header);
    }

    # HTTP 200 响应头成功 数据返回
    public function success($data)
    {
        return $this->respond(compact('data'));
    }

    # http 200 响应头成功 消息返回
    public function message($msg, $status = 'success')
    {
        return $this->respond(compact('msg'), $status);
    }

    # http 响应失败
    public function failed($msg, $code = 400){

        return $this->setStatusCode($code)->message($msg,'error');
    }




}