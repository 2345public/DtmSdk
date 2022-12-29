<?php

/**
 * Copyright (c) 2022,上海二三四五网络科技股份有限公司
 * 文件名称：DtmServer.php
 * 摘    要：接收端入口类
 * 作    者：linyj
 * 修改日期：2022.12.26
 */

namespace OA\DtmSdk;

use OA\DtmSdk\Exception\ClientException as Exception;
use OA\DtmSdk\Service\BarrierTrans;
use OA\DtmSdk\Service\SignCheck;

class DtmServer
{
    private $handler;

    /**
     * 初始化
     *
     * @param array $queryList
     * @param array $config
     * @param string $mode
     * @return void
     */
    public function __construct(array $queryList, array $config = [], string $mode = 'barrier')
    {
        $signObject = new SignCheck($config);
        $signObject->checkQuerySign($queryList);
        switch (strtolower($mode)) {
            case 'barrier':
                $this->handler = new BarrierTrans($queryList, $config);
                break;
            default:
                throw new Exception('ModeNotSupport', [$mode]);
        }
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array(array(&$this->handler, $name), $arguments);
    }

    /**
     * 响应成功
     *
     * @param array $data
     * @return void
     */
    public function responseSuccess(array $data)
    {
        http_response_code(200);
        echo json_encode($data);
    }

    /**
     * 响应失败
     *
     * @param array $data
     * @return void
     */
    public function responseFailed(array $data)
    {
        http_response_code(409);
        echo json_encode($data);
    }
}
