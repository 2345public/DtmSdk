<?php
/**
 * 配置接口
 */
namespace OA\DtmSdk\Contracts;

interface ConfigInterface
{
    /**
     * 获取某个模块下的具体配置
     * @author lynn
     * @DateTime 2022-01-29T14:13:36+0800
     * @param    string                   $key 配置名，以英文半角点号分隔，例如：auth.default.one
     * @return   mixed
     */
    public static function get(string $key);
}
