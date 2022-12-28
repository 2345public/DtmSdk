<?php
require "../../vendor/autoload.php";
require "Psr4Autoloader.php";
$loader = new \Keradus\Psr4Autoloader();
$loader->register();
$loader->addNamespace('OA\DtmSdk', realpath(__DIR__ . '/../'));

$params = 'app=ae&timestamp=1672041493&salt=63a95415e8538&sign=a8a4e5fe4a7e70dd8d4922b254b882d6f26b886768ce0ac86212112afa0ec4df';
parse_str($params, $_GET);
$_GET["trans_type"] = 'saga';
$_GET["gid"] = '001';
$_GET["branch_id"] = '002';
$_GET["op"] = 'confirm';
$_POST = ['hi'];
$queryList = $_GET;
$postData = $_POST;
try {
    $dtmServer = new OA\DtmSdk\DtmServer($queryList);
    $res   = $dtmServer->call(function() use ($postData){
        var_dump($postData);
        throw new \Exception('失败抛错', -1);
        return true;
    });
    $success = var_export($res, true);
    echo "server result: {$success}";
} catch (\Throwable $e) {
    // var_dump($e->getTraceAsString());
    echo "server with error: [" . $e->getCode() . "]" . $e->getMessage();
}
