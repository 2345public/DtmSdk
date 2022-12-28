<?php

/**
 * Copyright (c) 2022,上海二三四五网络科技股份有限公司
 * 文件名称：ClientException.php
 * 摘 要：客户端SDK异常类
 * 作 者：林永杰
 * 修改日期：2022.02.27
 */
namespace OA\DtmSdk\Exception;

use OA\DtmSdk\Service\Config;

class ClientException extends BaseException
{
    protected $errors = [
        'LoadModuleClassNotExist' => [
            'code'    => '1',
            'message' => '非法模块（%s）'
        ],
        'ModeNotSupport' => [
            'code'    => '2',
            'message' => '该模式暂不支持（%s）'
        ],
        'GidIsEmpty' => [
            'code'    => '3',
            'message' => 'gid不能为空'
        ],
        'DtmHostIsEmpty' => [
            'code'    => '4',
            'message' => 'dtm地址不能为空'
        ],
        'GetUrlFailed' => [
            'code'    => '5',
            'message' => '获取%s信息失败：%s'
        ],
        'PostUrlFailed' => [
            'code'    => '6',
            'message' => '请求%s失败：%s'
        ],
        'AppError' => [
            'code'    => '7',
            'message' => '参数app错误'
        ],
        'SignError' => [
            'code'    => '8',
            'message' => '签名错误'
        ],
    ];

    /**
     * 设置基数
     * @author lynn
     * @DateTime 2021-11-16T14:20:49+0800
     * @return void
     */
    public function setModule()
    {
        //获取配置
        $this->module = Config::get('errcodes.error_dtm_client');
    }
}
