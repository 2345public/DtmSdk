<?php
/**
 * 单例接口
 */
namespace OA\DtmSdk\Contracts;

interface SingletonInterface
{
    /**
     * 单例入口
     * @author lynn
     * @DateTime 2022-01-28T14:11:38+0800
     * @return   object
     */
    public static function getInstance();
}
