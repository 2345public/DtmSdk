<?php

namespace OA\DtmSdk\Service;

use OA\DtmSdk\Exception\ClientException as Exception;
use OA\DtmSdk\Constant\DtmConstant;
use OA\DtmSdk\Traits\HttpTrait;
use OA\DtmSdk\Traits\UtilsTrait;
use OA\DtmSdk\Service\Config;

abstract class TransBase
{
    use HttpTrait;
    use UtilsTrait;

    // 事务gid
    public $transGid = "";
    // dtm服务地址
    protected $dtmHost = "";
    // 事务顺序
    public $transSteps = [];
    // 接口负载
    public $payloads = [];
    // 消息超时查询地址
    public $queryUrl = "";
    // 是否等待事务结果
    protected $waitResult = false;
    //http基本配置
    private $config = [];
    //是否开启调试模式
    protected $debug = false;
    //签名基本配置
    private $signConfig = [];
    //默认配置文件名
    private $configName = 'client';
    //失败重试次数
    private $retryCount = 0;

    public function __construct(array $config = [])
    {
        $configDefault = Config::get($this->configName);
        $config = array_merge($configDefault, $config);
        $this->debug = $config['debug'];
        $this->waitResult = $config['wait_result'];

        $defaultProtocol = $config['default_protocol'];
        $this->dtmHost = $config[$defaultProtocol]['dtm_host'];
        $this->config = $config[$defaultProtocol]['client'];
        $this->retryCount = max($config[$defaultProtocol]['retry_count'], 0);

        $defaultApp = $config['default_app'];
        $this->signConfig = $config[$defaultApp];
        if ($this->dtmHost == "") {
            throw new Exception('DtmHostIsEmpty');
        }
    }

    /**
     * @param bool $waitResult
     */
    public function setWaitResult(bool $waitResult)
    {
        $this->waitResult = $waitResult;
        return $this;
    }

    /**
     * @throws Exception
     */
    protected function prepareRequest(array $postData = []): bool
    {
        $this->postJson(DtmConstant::TransPreparePath, $postData);
        return true;
    }

    /**
     * @throws Exception
     */
    protected function abortRequest(array $postData = []): bool
    {
        $this->postJson(DtmConstant::TransAbortPath, $postData);
        return true;
    }

    /**
     * @throws Exception
     */
    protected function submitRequest(array $postData): bool
    {
        $this->postJson(DtmConstant::TransSubmitPath, $postData);
        return true;
    }

    /**
     * @throws Exception
     */
    public function createNewGid(): string
    {
        $response = $this->get(DtmConstant::GetNewGidPath);
        return $response->gid;
    }

    /**
     * @throws Exception
     */
    public function registerBranch(array $postData): bool
    {
        $this->postJson(DtmConstant::RegisterTccBranchPath, $postData);
        return true;
    }

    /**
     * @throws Exception
     */
    public function requestBranch(array $postData, string $branchId, $tryUrl, $transType, $operate): bool
    {
        $queryData = [
            "dtm"        => sprintf("%s%s", $this->dtmHost, "/api/dtmsvr"),
            "gid"        => $this->transGid,
            "branch_id"  => $branchId,
            "trans_type" => $transType,
            "op"         => $operate
        ];
        $options = [
            "query" => http_build_query($queryData),
            "json"  => $postData,
        ];
        $this->postOrigin($tryUrl, $options);
        return true;
    }

    public function withGid(string $transGid): TransBase
    {
        $this->transGid = $transGid;
        return $this;
    }
}
