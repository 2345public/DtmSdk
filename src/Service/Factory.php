<?php
/**
 * Copyright (c) 2022,上海二三四五网络科技股份有限公司
 * 文件名称：Config.php
 * 摘    要：工厂类
 * 作    者：linyj
 * 修改日期：2022.01.28
 */

namespace OA\DtmSdk\Service;

use OA\DtmSdk\Contracts\FactoryInterface;
use OA\DtmSdk\Service\Config;
use OA\DtmSdk\Exception\ClientException;

class Factory implements FactoryInterface
{
    /**
     * 装载某个模块下的类
     * @author lynn
     * @DateTime 2022-01-28T13:58:50+0800
     * @param    string                   $module    [description]
     * @param    string                   $className [description]
     * @return   object
     */
    public static function load(string $module, string $className = '')
    {
        if ($className == '') {
            //取默认配置
            $className = Config::get($module . '.default');
        }
        $interface = '\\OA\\DtmSdk\\Contracts\\SingletonInterface';
        $class = '\\OA\\DtmSdk\\' . ucfirst($module) . '\\' . ucfirst($className);
        if (!class_exists($class)) {
            throw new ClientException('LoadModuleClassNotExist', [$class]);
        }
        $object = new \ReflectionClass($class);
        if ($object->implementsInterface($interface)) {
            $class = $class::getInstance();
        } else {
            $class = new $class();
        }
        return $class;
    }
}
