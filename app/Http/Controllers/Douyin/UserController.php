<?php

namespace App\Http\Controllers\Douyin;

use App\Http\Controllers\Controller;
use App\Models\Douyin\User;
use App\Util\Douyin\Api\DouplusOrderItemList;
use App\Util\Douyin\Api\DouplusOrderStatByItem;
use App\Util\Douyin\GetPidRequest;
use App\Util\Douyin\GetUserInfoRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Util\Douyin\Request as ApiRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()->paginate()->appends($request->all());

        return view('douyin.user.index', compact('users'));
    }

    public function getQrcode()
    {
        $url = 'https://www.douyin.com/passport/web/check_qrconnect/?aid=1128&next=https:%2F%2Fwww.douyin.com%2Flogin%2Fcallback%2F%3Fnext%3Dhttps%253A%252F%252Fwww.douyin.com%252Fpages%252Fdouyin_recharge%252Findex.html&token=123';

        return json_decode((new Client())->request('get', $url)->getBody()->getContents(), 1);
    }

    public function checkQrcode($token)
    {
        $url = 'https://www.douyin.com/passport/web/check_qrconnect/?aid=1128&next=https:%2F%2Fwww.douyin.com%2Flogin%2Fcallback%2F%3Fnext%3Dhttps%253A%252F%252Fwww.douyin.com%252Fpages%252Fdouyin_recharge%252Findex.html&token=' . $token;

        $request = (new Client())->request('get', $url);

        $res = json_decode($request->getBody()->getContents(), 1);

        //确认登录
        if ($res['data']['status'] === 'confirmed') {
            //实例化模型
            $user = new User();
            //获取set-cookie
            $setCookies = $request->getHeader('Set-Cookie');

            foreach ($setCookies as $setCookie) {
                if (stripos($setCookie, 'sid_guard') !== false) {
                    $guardArr = explode('|', urldecode(explode(';', $setCookie)[0]));
                    //获取sessionid和预估失效时间
                    $user->cookie = str_replace('sid_guard', 'sessionid', $guardArr[0]);
                    $user->cookie_status = true;
                    $user->cookie_expire_time = date('Y-m-d H:i:s', $guardArr[1] + $guardArr[2]);
                }
            }

            $api = new ApiRequest();

            $pidApi = new GetPidRequest();
            $userApi = new GetUserInfoRequest();

            //获取淘宝pid
            $user->pid = $api->request($pidApi, $user);
            //获取用户信息
            $user->fillUserInfo($api->request($userApi, $user));
            //保存
            $group_id = auth()->user()->group_id;
            if ($existsUser = User::query()->withoutGlobalScopes()->where('uid', $user->uid)->first()) {
                if ($existsUser->group_id !== $group_id) {
                    abort(400, "`{$existsUser->nickname}`" . '账号已录入其他团队');
                }
                //更新已存在账号数据
                $user = $existsUser->forceFill($user->toArray());
            } else {
                //新账号录入
                $user->group_id = $group_id;
            }

            $user->save();
        }

        return $res;

    }

    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }
}
