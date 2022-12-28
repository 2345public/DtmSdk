<?php

namespace OA\DtmSdk\Traits;

use OA\DtmSdk\Exception\ClientException as Exception;
use OA\DtmSdk\Service\Factory;
use OA\DtmSdk\Contracts\SignInterface;

trait UtilsTrait
{
    private $signModule = 'sign'; //加签模块

    /**
     * 装载对应签名类
     * @author lynn
     * @DateTime 2022-02-15T09:52:29+0800
     * @param    string                   $module [description]
     * @param    string                   $className [description]
     * @return   SignInterface
     */
    private function load(string $module, string $className = ''):SignInterface
    {
        return Factory::load($module, $className);
    }

    /**
     * 组合url（包括：拼接域名、加签）
     *
     * @param string $path 访问地址
     * @return string
     */
    protected function combineUrl(string $path): string
    {
        $config = $this->signConfig;
        $app = $config['app'];
        $token = $config['token'];
        //取默认的加签方式
        $signObject = $this->load($this->signModule);
        $data = [
            'app' => $app,
            'timestamp' => time(),
            'salt' => uniqid(),
        ];
        $data['sign'] = $signObject->generateSign($data, $token);
        $params = http_build_query($data);

        return sprintf("%s%s?%s", $this->dtmHost, $path, $params);
    }

    /**
     * 校验签名
     *
     * @param array $queryList 待校验参数
     * @param string $sign 待校验签名
     * @return void
     */
    public function checkSign(array $queryList, string $sign)
    {
        $config = $this->signConfig;
        $app = $config['app'];
        $token = $config['token'];
        $data = [
            'app' => $queryList['app'],
            'timestamp' => $queryList['timestamp'],
            'salt' => $queryList['salt'],
        ];
        if ($app != $data['app']) {
            throw new Exception('AppError');
        }
        //取默认的加签方式
        $signObject = $this->load($this->signModule);
        $isPass = $signObject->checkSign($data, $token, $sign);
        if (!$isPass) {
            throw new Exception('SignError');
        }
    }
}