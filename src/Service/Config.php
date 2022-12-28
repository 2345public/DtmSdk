<?php

namespace OA\DtmSdk\Service;

use OA\DtmSdk\Contracts\ConfigInterface;

/**
 * Copyright (c) 2022,上海二三四五网络科技股份有限公司
 * 文件名称：Config.php
 * 摘    要：配置文件操作类
 * 作    者：linyj
 * 修改日期：2022.01.28
 */
defined('DTM_CLIENT_CONFIG_DIR') or define('DTM_CLIENT_CONFIG_DIR', realpath(__DIR__ . '/../Config'));

class Config implements ConfigInterface
{
    private static $config;

    /**
     * load function
     *
     * @param string $configFile configFile
     * 
     * @return void
     */
    private static function load(string $configFile)
    {
        $config = include $configFile;
        return $config;
    }

    /**
     * load module function
     *
     * @param string $module configFile
     * 
     * @return void
     */
    private static function loadModule(string $module)
    {
        self::$config[$module] = self::load(DTM_CLIENT_CONFIG_DIR . '/' . $module . '.php');
    }

    /**
     * 获取某个模块下的具体配置
     * @author lynn
     * @DateTime 2022-01-29T14:13:36+0800
     * @param    string                   $key 配置名，以英文半角点号分隔，例如：auth.default.one
     * @return   mixed
     */
    public static function get(string $key)
    {
        $keys = explode('.', $key);
        $module = $keys[0];
        $config = self::$config;
        //自动加载模块配置
        if (!isset($config[$module])) {
            self::loadModule($module);
            $config = self::$config;
        }
        foreach ($keys as $one) {
            if (isset($config[$one])) {
                $config = $config[$one];
            } else {
                return null;
            }
        }
        return $config;
    }
}
