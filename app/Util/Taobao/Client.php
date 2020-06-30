<?php


namespace App\Util\Taobao;

use GuzzleHttp\Client as HttpClient;

class Client
{
    protected $appkey;
    protected $secretKey;


    public function __construct()
    {
        $this->appkey = config('taobao.app_key');
        $this->secretKey = config('taobao.app_secret');
    }

    public function exec(RequestContract $request, $session = null)
    {
        //工共请求参数
        $query['method'] = $request->getApiMethodName();
        $query['app_key'] = $this->appkey;
        $query['sign_method'] = 'md5';
        $query['timestamp'] = date("Y-m-d H:i:s");
        $query['format'] = 'json';
        $query['v'] = '2.0';
        if ($session !== null)
            $query['session'] = $session;

        //请求参数
        $formParams = $request->getApiFormParams();

        $query['sign'] = $this->createSign(array_merge($formParams, $query));

        $url = 'http://gw.api.taobao.com/router/rest?' . http_build_query($query);

        $content = (new HttpClient())->request('POST', $url, [
            'form_params' => $formParams
        ])->getBody()->getContents();

        return json_decode($content, 1);
    }

    //签名函数
    public function createSign($paramArr)
    {
        $sign = $this->secretKey;

        ksort($paramArr);

        foreach ($paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $sign .= $key . $val;
            }
        }

        $sign .= $this->secretKey;
        $sign = strtoupper(md5($sign));

        return $sign;
    }
}
