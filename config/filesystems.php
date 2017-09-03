<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'qiniu',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'upyun' => [
            'driver'        => 'upyun',
            'bucket'        => env('UPYUN_BUCKET'),
            'operator'      => env('UPYUN_OPERATOR'),
            'password'      => env('UPYUN_PASSWORD'),
            'domain'        => env('UPYUN_DOMAIN'),
            'protocol'      => env('UPYUN_PROTOCOL'),
        ],

        'qiniu' => [
            'driver'  => 'qiniu',
            'domains' => [
                'default'   => '7qnb9q.com1.z0.glb.clouddn.com', //你的七牛域名
                'https'     => 'o6qdyzx6o.qnssl.com',         //你的HTTPS域名
                'custom'    => 'static.xtwind.com',                //你的自定义域名
            ],
            'access_key'=> 'a1uh_gNUH82EDljI63PPpYq2ki5hQJnY0_32B10V',  //AccessKey
            'secret_key'=> 'BeTthX3_P9mVH3zDvfBWYP3bB7q2gotrmcgaZm7h',  //SecretKey
            'bucket'    => 'summerwind',  //Bucket名字
            'notify_url'=> '',  //持久化处理回调地址
            'access'    => 'public'  //空间访问控制 public 或 private
        ],

    ],

];
