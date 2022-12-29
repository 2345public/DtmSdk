<?php

namespace OA\DtmSdk\Service;

use OA\DtmSdk\Exception\ClientException as Exception;
use OA\DtmSdk\Constant\DtmConstant;
use OA\DtmSdk\Traits\HttpTrait;
use OA\DtmSdk\Traits\UtilsTrait;
use OA\DtmSdk\Service\Config;

class SignCheck
{
    use UtilsTrait;

    //是否开启调试模式
    protected $debug = false;
    //签名基本配置
    private $signConfig = [];
    //默认配置文件名
    private $configName = 'client';

    public function __construct(array $config = [])
    {
        $configDefault = Config::get($this->configName);
        $config = array_merge($configDefault, $config);
        $this->debug = $config['debug'];
        $this->signConfig = $config['default'];
    }

    /**
     * 校验请求的签名
     *
     * @param array $queryList
     * @return void
     */
    public function checkQuerySign(array $queryList)
    {
        if ($this->debug) {
            return ;
        }
        $this->checkSign($queryList, $queryList['sign'] ?: '');
    }
}
