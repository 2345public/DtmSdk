<?php
/**
 * 模块工厂接口
 */
namespace OA\DtmSdk\Contracts;

interface FactoryInterface
{
    /**
     * 装载对应模块下的类
     * @author lynn
     * @DateTime 2022-01-27T18:23:17+0800
     * @param    string                   $module    模块名
     * @param    string                   $className 模块下类名
     * @return   object
     */
    public static function load(string $module, string $className = '');
}
