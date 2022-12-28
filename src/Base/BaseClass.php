<?php

/**
 * Copyright (c) 2022,上海二三四五网络科技股份有限公司
 * 文件名称：BaseClass.php
 * 摘    要：基类
 * 作    者：linyj
 * 修改日期：2022.01.28
 */
namespace OA\DtmSdk\Base;

use OA\DtmSdk\Contracts\SingletonInterface;

abstract class BaseClass implements SingletonInterface
{
    protected static $instances = [];

    /**
     * __construct function
     * 
     * @return self
     */
    protected function __construct()
    {
    }

    /**
     * getInstance function
     *
     * @return static
     */
    public static function getInstance()
    {
        $className = get_called_class();
        if (!isset(static::$instances[$className])) {
            static::$instances[$className] = new static();
        }
        return static::$instances[$className];
    }
}
