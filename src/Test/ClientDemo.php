<?php
require "../../vendor/autoload.php";
require "Psr4Autoloader.php";
$loader = new \Keradus\Psr4Autoloader();
$loader->register();
$loader->addNamespace('OA\DtmSdk', realpath(__DIR__ . '/../'));

$baseUrl = "http://ae.dev.2345.cn/DtmApi";
$data = [
    'process_code' => '6FRm5fxreVpQ',
    'order_number' => 'kaoqin_holiday_123',
    'operator' => '陈于冰',
    'project_name' => '',
    'filter_users' => '',
    'call_back_type' => 1, //返回结果1异步（默认）2同步（非必填），此处必须为1
    'field_list' => [
        [
            'field' => '',
            'field_name' => '',
            'value' => '',
            'value_show' => '',
            'list' => '',
            'condition' => '',
            'card' => '',
            'emp' => '',
            'attach_url' => '',
            'link_url' => '',
            'card' => '',
        ],
    ],
    'previous_log_list' => [
        [
            'type' => '',
            'operator_uname' => '',
            'is_project' => '',
            'content' => '',
            'operator_type' => '',
            'status' => '',
            'created_at' => '',
            'updated_at' => '',
            'from_system' => '',
            'extra_json' => '',
        ],
    ],
];

try {
    $trans = new OA\DtmSdk\DtmClient();
    $gid   = $trans->createNewGid();
    $trans
        ->withGid($gid)
        ->withOperate($baseUrl . '/Approval/Audit/Add', $baseUrl . '/Approval/Audit/AddRevert', $data);
    $success = $trans->submit();
    echo "client transaction result: {$success}";
} catch (Exception $exception) {
    // $failed = $trans ? $trans->abort() : false;
    // var_dump($exception->getTraceAsString());
    echo "client transaction with error: " . $exception->getMessage();
}
