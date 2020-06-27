<?php

return [
    'app_key' => env('TAOBAO_APP_KEY'),
    'app_secret' => env('TAOBAO_APP_SECRET'),

    'oauth_url' => 'https://oauth.taobao.com/authorize',
    'oauth_redirect_uri' => env('TAOBAO_OAUTH_REDIRECT_URL'),
];
