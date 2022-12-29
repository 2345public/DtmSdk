<?php
/**
 * 客户端相关配置，包括签名key、密钥、方式
 */
use OA\DtmSdk\Utils\ToolsUtil;

return [
    /*
     |--------------------------------------------------------------------------
     | Default DTM Client Protocol
     |--------------------------------------------------------------------------
     |
     | 与DTM通信协议
     */
    'default_protocol' => ToolsUtil::env('DTM_CLIENT_PROTOCOL', 'http'),

    /*
     |--------------------------------------------------------------------------
     | DTM Client Debug
     |--------------------------------------------------------------------------
     |
     | 是否开启 debug ，开启后不校验 sign
     */
    'debug' => ToolsUtil::env('DTM_CLIENT_DEBUG', false),

    /*
     |--------------------------------------------------------------------------
     | DTM Client Sync
     |--------------------------------------------------------------------------
     |
     | 是否等待事务结果
     */
    'wait_result' => ToolsUtil::env('DTM_CLIENT_WAIT_RESULT', true),

    /*
     |--------------------------------------------------------------------------
     | Default DTM Client App Info
     |--------------------------------------------------------------------------
     |
     | 发起端依据此处配置读取 App 相关配置加签
     */
    'default_app' => 'default',

    /*
     |--------------------------------------------------------------------------
     | DTM Client/Server Key Info
     |--------------------------------------------------------------------------
     |
     | 接收端依据此处配置读取 App 相关配置验签
     */
    'default' => [
        'app' => ToolsUtil::env('DTM_CLIENT_APP', 'ae'),
        'token' => ToolsUtil::env('DTM_CLIENT_TOKEN', '21eds32e'),
    ],

    // other...

    'http' => [

        /*
        |--------------------------------------------------------------------------
        | Default DTM Client Key Info
        |--------------------------------------------------------------------------
        |
        | DTM服务地址
        */
        'dtm_host' => ToolsUtil::env('DTM_HOST', 'http://dtm'),
        /*
        |--------------------------------------------------------------------------
        | DTM Client retry count
        |--------------------------------------------------------------------------
        |
        | 失败重试次数
        */
        'retry_count' => ToolsUtil::env('DTM_CLIENT_RETRY_COUNT', 0),

        'client' => [
            /*
            |--------------------------------------------------------------------------
            | DTM Client verify
            |--------------------------------------------------------------------------
            |
            | SSL是否安全校验
            */
            'verify' => ToolsUtil::env('DTM_CLIENT_VERIFY', true),

            /*
            |--------------------------------------------------------------------------
            | DTM Client timeout
            |--------------------------------------------------------------------------
            |
            | 接口超时时间
            */
            'timeout' => ToolsUtil::env('DTM_CLIENT_TIMEOUT', 5),

            /*
            |--------------------------------------------------------------------------
            | DTM Client Connect Timeout
            |--------------------------------------------------------------------------
            |
            | 接口链接时间
            */
            'connect_timeout' => ToolsUtil::env('DTM_CLIENT_TIMEOUT', 5),
        ],
    ],
    /*
     |--------------------------------------------------------------------------
     | DTM barrier model
     |--------------------------------------------------------------------------
     |
     | 子事务屏障
     */
    'barrier' => [
        'switch' => ToolsUtil::env('DTM_BARRIER_SWITCH', false),
        'dbname' => ToolsUtil::env('DTM_BARRIER_DB_NAME', 'ae'),
        'host' => ToolsUtil::env('DTM_BARRIER_DB_HOST', 'mysql'),
        'port' => ToolsUtil::env('DTM_BARRIER_DB_PORT', '3306'),
        'username' => ToolsUtil::env('DTM_BARRIER_DB_USERNAME', 'root'),
        'password' => ToolsUtil::env('DTM_BARRIER_DB_PASSWORD', 'root'),
        'charset'  => 'utf8',
        'errmode' => \PDO::ERRMODE_EXCEPTION,
    ],
];
