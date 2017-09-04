<?php

return [

    // Mail Notification
    'mail_notification' => env('MAIL_NOTIFICATION') ?: false,

    // Default Avatar
    'default_avatar' => env('DEFAULT_AVATAR') ?: '/images/default.png',

    // Default Icon
    'default_icon' => env('DEFAULT_ICON') ?: '/images/favicon.ico',

    // Meta
    'meta' => [
        'keywords' => '夏天的风,夏天博客,blog,laravel,vuejs,php',
        'description' => '追求互联网技术,记录夏天对技术的追求与生活的热爱'
    ],

    // Social Share
    'social_share' => [
        'article_share'    => env('ARTICLE_SHARE') ?: true,
        'discussion_share' => env('DISCUSSION_SHARE') ?: true,
        'sites'            => env('SOCIAL_SHARE_SITES') ?: 'google,twitter,weibo',
        'mobile_sites'     => env('SOCIAL_SHARE_MOBILE_SITES') ?: 'google,twitter,weibo,qq,wechat',
    ],

    // Google Analytics
    'google' => [
        'id'   => env('GOOGLE_ANALYTICS_ID', 'Google-Analytics-ID'),
        'open' => env('GOOGLE_OPEN') ?: false
    ],

    // Article Page
    'article' => [
        'title'       => 'Nothing is impossible.',
        'description' => '',
        'number'      => 10,
        'sort'        => 'desc',
        'sortColumn'  => 'id',
    ],

    // Discussion Page
    'discussion' => [
        'number' => 20,
        'sort'   => 'desc',
        'sortColumn' => 'id',
    ],

    // Footer
    'footer' => [
        'github' => [
            'open' => true,
            'url'  => 'https://github.com/wh469012917',
        ],
        'twitter' => [
            'open' => false,
            'url'  => 'https://twitter.com/pigjian'
        ],
        'meta' => '人生如旅途，我们一边再见一边遇见',
    ],

    'license' => '采用 <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"> 知识共享 署名-非商业性使用 4.0 国际 许可协议</a> 进行许可',

];
