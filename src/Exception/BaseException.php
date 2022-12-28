<?php

/**
 * Copyright (c) 2022,上海二三四五网络科技股份有限公司
 * 文件名称：BaseException.php
 * 摘 要：异常处理基类
 * 作 者：林永杰
 * 修改日期：2022.01.28
 */
namespace OA\DtmSdk\Exception;

use Exception;

abstract class BaseException extends Exception
{
    protected int $module   = 0;
    protected $errors       = [];
    protected $defaultError = [
        'code'    => '1000',
        'message' => '未知的错误',
    ];

    /**
     * 构造一个自定义错误
     *
     * @param string        $tag        子类实现的自定义错误编码
     * @param array         $arguments  需要变量替换的模板
     * @param \Exception    $previous   getPrevious可用
     *
     */
    public function __construct($tag = '', $arguments = [], \Exception $previous = null)
    {
        extract($this->getCustomErrors($tag));
        parent::__construct(
            $this->getCustomMessage($message, $arguments),
            $this->getCustomCode($code),
            $previous
        );
    }

    /**
     * 获取自定义的报错信息
     *
     * @param string $message 消息
     * @param array $arguments 需要变量替换的内容，符合sprinf语法
     *
     * @return string
     */
    public function getCustomMessage($message, $arguments): string
    {
        if (is_array($arguments) && !empty($arguments)) {
            array_unshift($arguments, $message);
            $message = call_user_func_array('sprintf', $arguments);
        }
        return $message;
    }

    /**
     * 获取自定义的错误码
     * 模块id(2位) + 错误码(4位)
     * @param string $code 错误码
     *
     * @return string
     */
    protected function getCustomCode($code): int
    {
        $this->setModule();
        return -1 * ($this->module + (int)$code);
    }

    /**
     * 获取自定义的错误数组
     *
     * @param string $tag 错误代号
     *
     * @return array    ['code' => xxx, 'message' => 'xxxx']
     */
    protected function getCustomErrors($tag): array
    {
        return isset($this->errors[$tag]) ? $this->errors[$tag] : $this->defaultError;
    }

    /**
     * 根据getFile接口的真实文件路径获取类名（前提是符合psr4）
     *
     * @return string
     */
    public function getClass(): string
    {
        $realPath = $this->getFile();
        if (empty($realPath)) {
            return '';
        }
        $fileName = array_pop(explode("/", $realPath));
        return empty($fileName) ? '' : current(explode(".", $fileName));
    }

    /**
     * 格式化输出
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->message}[error:{$this->code},class:{$this->getClass()}]";
    }
}
