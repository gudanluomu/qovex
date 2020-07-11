<?php


namespace App\Util\Douyin;


abstract class AppRequest implements RequestContract
{
    public function comQuery(): array
    {
        return [
            'ac' => 'wifi',
            'aid' => 1128,
            'app_name' => 'aweme',
            'app_type' => 'normal',
            'channel' => '360_aweme',
            'cdid' => 'c36e0680-6610-4850-b207-d63a19c2bef3',
            'cpu_support64' => false,
            'device_brand' => 'Xiaomi',
            'device_platform' => 'android',
            'device_type' => 'MI 5s',
            'dpi' => 270,
            'host_abi' => 'armeabi-v7a',
            'language' => 'zh',
            'manifest_version_code' => 110001,
            'mcc_mnc' => 46003,
            'os_api' => 23,
            'os_version' => '8.1.0',
            'request_tag_from' => 'h5',
            'resolution' => '810*1440',
            'ssmix' => 'a',
            'update_version_code' => '11009900',
            'version_name' => '11.0.0',
            'version_code' => '110000',
            'openudid' => '1890c0263fa84f66',
            'uuid' => '990000000325417',
            //重要信息
            'iid' => '1943581320808910',
            'device_id' => '71134045284',
            '_rticket' => '123456789',
        ];
    }

    public function method(): string
    {
        return 'get';
    }

    public function verifyResponse($res)
    {
        if ($res && isset($res['status_code']) && $res['status_code'] == 0) {
            return $res;
        }

        return false;
    }

    public function isRisk(): bool
    {
        return false;
    }

    public function getCookie(UserContract $user)
    {
        return $user->getCookie();
    }

}
