<?php


namespace App\Util\Douyin\Api;


use App\Util\Douyin\UserContract;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class BaseApi
{
    /**
     * @var Client
     */
    public $client;

    /**
     * @var ResponseInterface
     */
    public $request;

    /**
     * @var UserContract
     */
    public $user;//账号

    public $query;

    public $headers;

    public $options;

    public $risk = false;

    public $xgUrl;

    public function __construct()
    {
        $this->client = new Client();
    }

    //请求地址 不带query
    abstract public function getUrl(): string;

    //请求账号,需要cookie设置
    public function setUser(UserContract $user)
    {
        $this->user = $user;
        //设置cookie
        $this->setHeaders('Cookie', $this->getCookie());

        return $this;
    }

    //设置headers https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html#headers
    public function setHeaders($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    //获取header
    public function getHeaders()
    {
        return (array)$this->headers;
    }

    //设置请求参数
    public function setQuery($key, $value)
    {
        $this->query[$key] = $value;
        //query 改变,xg改变
        $this->setXgUrl(null);

        return $this;
    }

    //获取cookie
    public function getCookie()
    {
        return $this->user ? $this->user->getCookie() : null;
    }

    //请求方式
    public function getMethod()
    {
        return 'GET';
    }

    //获取query
    public function getQuery()
    {
        return array_merge(
            $this->comQuery(),
            (array)$this->query
        );
    }

    //请求选项 https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html
    public function getOptions()
    {
        return array_merge([
            'headers' => $this->getHeaders(),
        ], (array)$this->options);
    }

    //设置请求选项
    public function setOptions($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    //完整url
    public function getQueryUrl()
    {
        return $this->xgUrl ?: (rtrim($this->getUrl(), '?') . '?' . http_build_query($this->getQuery()));
    }

    public function setXgUrl($url)
    {
        $this->xgUrl = $url;
        return $this;
    }

    //验证是否风控
    public function isRisk()
    {
        if ($this->risk && !$this->xgUrl) {
            //11版本获取xg必改参数
            $this->setQuery('_rticket', '123456789');

            $xg = (new DouyinXg($this->getQueryUrl()))->request()->getContents();

            $this->setHeaders('X-Khronos', $xg['khronos']);
            $this->setHeaders('X-Gorgon', $xg['gorgon']);

            $this->xgUrl = $xg['url'];
        }
    }

    //请求
    public function request()
    {
        $this->isRisk();

        $this->request = $this->client->request(
            $this->getMethod(),
            $this->getQueryUrl(),
            $this->getOptions()
        );

        return $this;
    }

    //异步请求
    public function requestAsync($onFulfilled = null, $onRejected = null)
    {
        $this->isRisk();

        //是否需要回调
        if ($onFulfilled || $onRejected)
            $this->setOptions('synchronous', true);

        $this->client
            ->requestAsync($this->getMethod(), $this->getQueryUrl(), $this->getOptions())
            ->then($onFulfilled, $onRejected);

    }

    //请求返回内容
    public function getContents()
    {
        return json_decode($this->request->getBody()->getContents(), 1);
    }

    //工共请求参数
    public function comQuery(): array
    {
        return [
            'ac' => 'wifi',
            'aid' => 1128,
            'app_name' => 'aweme',
            'app_type' => 'normal',
            'channel' => '360_aweme',
//            'cdid' => 'c36e0680-6610-4850-b207-d63a19c2bef3',
            'cpu_support64' => false,
            'device_brand' => 'Xiaomi',
            'device_platform' => 'android',
            'device_type' => 'MI 5s',
            'dpi' => 270,
            '_rticket' => 123456789,
            'host_abi' => 'armeabi-v7a',
            'language' => 'zh',
            'manifest_version_code' => 110001,
            'mcc_mnc' => 46003,
            'os_api' => 23,
            'os_version' => '8.1.0',
            'request_tag_from' => 'h5',
            'resolution' => '810*1440',
            'ssmix' => 'a',
            'update_version_code' => 11009900,
            'version_name' => '11.0.0',
            'version_code' => 110000,
            'openudid' => '1890c0263fa84f66',
            'uuid' => '990000000325417',
            //重要信息
            'iid' => '1943581320808910',
            'device_id' => '71134045284',
        ];
    }
}
