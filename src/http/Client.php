<?php

namespace Qiyewechat\http;

use GuzzleHttp\Client as GzClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * 客户端
 */
class Client implements ClientInterface
{
    /**
     * 接口请求的host
     *
     * @var string
     */
    protected $host = '';

    /**
     * 接口请求的端口号
     *
     * @var string
     */
    protected $port = '';

    /**
     * 获取请求消息体 新request请求参数实体设置
     *
     *
     * @extends
     * ```
     *  提交json数据
     *  [
     *       'body' => 'json raw data'
     *   ])
     *  或者 提交form表单
     *  'form_params' => [
     *       'field_name' => 'abc',
     *       'other_field' => '123',
     *       'nested_field' => [
     *           'nested' => 'hello'
     *       ]
     *   ]
     *  上传图片或者文件
     * 'multipart' => [
     *       [
     *           'name'     => 'field_name',
     *           'contents' => 'abc'
     *       ],
     *       [
     *           'name'     => 'file_name',
     *           'contents' => fopen('/path/to/file', 'r')
     *       ],
     *       [
     *           'name'     => 'other_file',
     *           'contents' => 'hello',
     *           'filename' => 'filename.txt',
     *           'headers'  => [
     *               'X-Foo' => 'this is an extra header to include'
     *           ]
     *       ]
     *   ]
     *  GET请求参数
     *  'query' => ['foo' => 'bar']
     *
     * ```
     */
    public function send(Request $request): array
    {
        $method = $request->method;
        $url    = rtrim($this->host, '/');
        if ($this->port) {
            $url .= ':' . $this->port;
        }
        $error = [];
        try {
            $request->checkParams();
            $options  = $request->getParams();
            $client   = new GzClient(['base_uri' => $url]);
            if (!$request->before()) {
                return [];
            }
            $res      = $client->request($method, $request->getUri(), $options);
            $response = $res->getBody()->getContents();
            if ($response) {
                $data = json_decode($response, true);
                return $request->after($data, $error);
            }
        } catch (GuzzleException $e) {
            $error = $e;
        }
        return $request->after([], $error);
    }
}
