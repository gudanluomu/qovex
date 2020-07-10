<?php

namespace App\Http\Controllers;

use App\Douplus;
use App\Http\Requests\DouplusRequest;
use App\Models\Douyin\User;
use App\Models\Douyin\Video;
use App\Util\Douyin\WebApi;
use Illuminate\Http\Request;

class DouplusController extends Controller
{
    public function index(Request $request)
    {
        $douplus = Douplus::query()
            ->orderByDesc('created_at')
            ->paginate()
            ->appends($request->all());

        return view('douplus.index', compact('douplus'));
    }

    public function create(Request $request, WebApi $api)
    {
        $video = Video::query()->with('dyuser')->where('aweme_id', $request->aweme_id)->first();

        if (is_null($video)) {
            abort(400, '参数异常');
        }

        //获取视频信息并更新
        $video = Video::createByApi($api->getVideoInfo($video));

        if ($video->is_private) {
            abort(400, '视频仅自己可见');
        }

        //期望提升
        $aim = [
            //'113' => '店铺引流(高级互动)(淘宝)',
            //'53' => '新(智能优化)(小店)',
            '44' => '点赞评论',
            '46' => '粉丝量',
        ];

        //带货的aim参数略有不同
        if ($key = $video->getDouplusGoodsAimKey()) {
            $aim = array_merge([$key => '智能优化'], $aim);
        }

        //投放时长
        $duration = [
            '24' => '24小时',
            '12' => '12小时',
            '6' => '6小时',
            '2' => '2小时',
        ];

        //投放方式
        $delivery_type = [
            1 => '系统智能推荐',
            2 => '自定义定向推荐',
            5 => '购买意向人群',
        ];

        //投放金额
        $budget = [
            '100' => '100',
            '200' => '200',
            '500' => '500',
            '1000' => '1000',
            '2000' => '2000',
        ];

        //自定义选项
        $custom_options = [
            'gender' => [
                'title' => '性别',
                'multiple' => false,
                'data' => [
                    null => '不限',
                    1 => '男',
                    2 => '女'
                ]
            ],
            'age_range_codes' => [
                'title' => '年龄',
                'multiple' => true,
                'data' => [
                    11 => '18-23岁',
                    12 => '24-30岁',
                    13 => '31-40岁',
                    14 => '41-50岁',
                    15 => '50岁+',
                ]
            ],
            'interests' => [
                'title' => '兴趣标签',
                'multiple' => true,
                'data' => [
                    '10003' => "金融",
                    '10007' => "汽车",
                    '10005' => "旅游",
                    '10009' => "房产",
                    '10012' => "科技",
                    '10017' => "娱乐",
                    '10002' => "家装",
                    '10014' => "生活",
                    '10001' => "游戏",
                    '10004' => "教育",
                    '10013' => "体育",
                    '10010' => "美食",
                    '10011' => "母婴",
                    '10015' => "健康",
                    '10016' => "法律",
                    '10006' => "服饰",
                    '10008' => "美妆",
                    '10018' => "商务服务"
                ]
            ],
        ];

        $payUsers = User::query()->where('cookie_status', true)->get(['id', 'nickname', 'unique_id']);

        return view('douplus.create', compact('aim', 'duration', 'delivery_type', 'budget', 'custom_options', 'payUsers', 'video'));

    }

    public function store(DouplusRequest $request, WebApi $api, Douplus $douplus)
    {
        $video = Video::query()->findOrFail($request->video_id);

        //默认dou+参数
        $douplusField = [
            'aim', 'budget', 'delivery_type', 'duration'
        ];

        //自定义豆荚参数
        if ($request->delivery_type == 2) {
            array_push($douplusField, 'gender', 'age_range_codes', 'interests');
        }

        $douplusAttr = $request->only($douplusField);

        //豆荚参数
        $douplusParams = array_map(function ($item) {
            return is_array($item) ? implode(',', $item) : $item;
        }, $douplusAttr);

        $douplusParams['budget_int'] = $request->budget * 1000;
        $douplusParams['estimate_show'] = $request->budget * 50;
        $douplusParams['duration'] = $request->duration * 3600;

        //DOU+ API
        $res = $api->douplusOrderCreate($request->pay_user, $video, $douplusParams, $request->num);

        $attr = [
            'info' => $douplusAttr,
            'aweme_id' => $video->aweme_id,
            'author_user_id' => $video->author_user_id,
            'pay_user_id' => $request->pay_user->uid,
            'is_run' => true,
            'budget_num' => $request->num,
            'real_num' => $res['real_num'],
            'contents' => $res['contents'],
            'budget_amount' => $request->budget * $request->num,
            'real_amount' => $request->budget * $res['real_num'],
            'creator_id' => auth()->id(),
            'group_id' => auth()->user()->group_id,
            'user_id' => $video->user_id,
            'department_id' => $video->department_id,
        ];

        $douplus->forceFill($attr)->save();

        return redirect()->route('douplus.index');
    }
}
