<?php

namespace App\Http\Controllers\Taobao;

use App\Http\Controllers\Controller;
use App\Models\TaobaoAuth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $auths = TaobaoAuth::query()->paginate()->appends($request->all());

        return view('taobao.auth.index', compact('auths'));
    }

    public function create()
    {
        $state = encrypt(json_encode([
            'group_id' => auth()->user()->group_id
        ]));

        $query = [
            'response_type' => 'code',
            'client_id' => config('taobao.app_key'),
            'redirect_uri' => config('taobao.oauth_redirect_uri'),
            'state' => $state,
            'view' => 'web'
        ];

        $url = config('taobao.oauth_url') . '?' . http_build_query($query);

        return redirect($url);
    }

    public function store(Request $request, TaobaoAuth $auth)
    {
        try {
            $state = json_decode(decrypt($request->state), 1);
        } catch (DecryptException $e) {
            return route('callback', [
                'redirect_url' => route('taobao-auth.index'),
                'errors' => '参数异常'
            ]);
        }

        $data = json_decode($request->data, 1);

        $auth->group_id = $state['group_id'];

        $auth->newQuery()->updateOrCreate(Arr::only($data, 'taobao_user_id'), $data);

        return route('callback', [
            'redirect_url' => route('taobao.auth.index'),
        ]);
    }

    public function destroy(TaobaoAuth $auth)
    {
        $auth->delete();

        return back();
    }
}
