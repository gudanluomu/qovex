<?php


namespace App\Util\Douyin;


use App\Exceptions\ApiRequestException;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use GuzzleHttp\Promise;

class Request
{
    public $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    //工共请求方法
    public function request(RequestContract $request, $user = null, $num = 1)
    {
        list($url, $options) = [$request->url(), $request->options()];
        //接口是否风控
        if ($request->isRisk()) {
            list($url, $options) = $this->getRiskRequestOptions($url, $options);
        }
        //Cookie
        if ($user instanceof UserContract) {
            //单次
            $options['headers']['Cookie'] = $request->getCookie($user);
            //并发多次
            if ($num > 1) {
                return $this->pollRequest($request, $user, $url, $options, $num);
            }
        } elseif ($user instanceof Collection) {
            //并发
            return $this->promiseRequest($request, $user, $url, $options);
        }

        $response = json_decode($this->client->request($request->method(), $url, $options)->getBody()->getContents(), 1);

        if (($res = $request->verifyResponse($response)) !== false) {
            return $res;
        }

        throw new ApiRequestException(get_class($request), $response);
    }

    //并发
    public function promiseRequest(RequestContract $request, Collection $user, $url, $options)
    {
        $client = new Client(['base_uri' => $url]);

        $promises = [];

        $user->each(function (UserContract $user) use (&$promises, $client, $options, $request) {

            $options['headers']['Cookie'] = $request->getCookie($user);

            $promises[$user->id] = $client->getAsync(null, $options);
        });

        $results = Promise\unwrap($promises);

        return collect($results)->map(function ($item) use ($request) {
            $response = json_decode($item->getBody()->getContents(), 1);
            return $request->verifyResponse($response);
        });
    }

    //并发
    public function pollRequest(RequestContract $request, UserContract $user, $url, $options, $num)
    {
        $url = $this->buildUrlQuery($url, $options['query'] ?? null);
        //成功次数
        $real_num = 0;
        //返回内容arr
        $contents = [];

        $requests = function ($total) use ($options, $url, $request) {
            for ($i = 0; $i < $total; $i++) {
                yield new \GuzzleHttp\Psr7\Request($request->method(), $url, $options['headers'] ?? []);
            }
        };

        $pool = new Pool($this->client, $requests($num), [
            'concurrency' => 50,

            'fulfilled' => function ($response) use (&$real_num, &$contents, $request) {

                $content = json_decode($response->getBody()->getContents(), 1);

                $res = $request->verifyResponse($content);

                if ($res !== false) {
                    $real_num++;
                }

                $contents[] = $res;
            }
        ]);

        //启动
        $promise = $pool->promise();
        //执行
        $promise->wait();

        return compact('real_num', 'contents');
    }

    //risk请求选项
    public function getRiskRequestOptions($url, $options = [])
    {
        $query = $options['query'] ?? null;

        if ($query)
            $query['_rticket'] = '123456789';

        $url = $this->buildUrlQuery($url, $query);

        $risk = $this->getRisk($url);

        unset($options['query']);

        $options['headers'] = array_merge($options['headers'] ?? [], [
            'X-Khronos' => $risk['khronos'],
            'X-Gorgon' => $risk['gorgon'],
        ]);

        return [$risk['url'], $options];
    }

    protected function buildUrlQuery($url, $query)
    {
        if ($query) {
            return rtrim($url, '?') . '?' . http_build_query($query);
        }

        return $url;
    }

    //获取risk
    public function getRisk($url)
    {
        return json_decode((new Client())->request('get', '47.114.43.205:47107/api?url=' . urlencode($url))->getBody()->getContents(), 1);
    }
}
