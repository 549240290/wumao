<?php
/**
* 
*   API 接口返回 Traits
*
**/
namespace App\Http\Controllers\Api\Traits;

use Response;

trait ApiResponseTraits
{
    protected $statusCode = 200;

    # HTTP 200 响应头成功 且返回相应数据
    public function success($data)
    {
        $respond = [
            'status'        => 'success',
            'status_code'   => 200,
            'data'          => compact('data')
        ];
        return $this->respond( array_merge($respond, compact('data')) );
    }

    # http 200 响应头成功 但存在异常 返回错误信息
    public function message($message, $status_code = 200)
    {
        $respond = [
            'status_code'   => $status_code,
            'status'        => $status_code == 200 ? 'success' : 'fail',
            'message'       => compact('message')
        ];
        return $this->respond( $respond );
    }

    # http 响应失败  比如 400 401 402 403 500 501 等
    public function failed( $code = 400, $message = '')
    {
        return $this->setStatusCode( $code )->respond(compact('message'));
    }

    # 发送响应
    public function respond( array $data = [] ,$header = [])
    {
        return Response::json( $data, $this->getStatusCode(),$header);
    }

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
}