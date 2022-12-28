<?php
/**
 * 签名接口
 */
namespace OA\DtmSdk\Contracts;

interface SignInterface
{
    /**
     * 生成签名
     * @author lynn
     * @DateTime 2022-01-27T18:23:17+0800
     * @param    array                    $data            待签名数据
     * @param    string                   $appSecret       签名密钥
     * @return   string 签名
     */
    public function generateSign(array $data, string $appSecret):string;

    /**
     * 校验签名
     * @author lynn
     * @DateTime 2022-01-27T18:23:17+0800
     * @param    array                    $data            待签名数据
     * @param    string                   $appSecret       签名密钥
     * @param    string                   $sign            待校验签名
     * @return   bool 是否验证通过
     */
    public function checkSign(array $data, string $appSecret, string $sign):bool;

    /**
     * 获取签名方式名
     * @author lynn
     * @DateTime 2022-01-30T09:48:32+0800
     * @return   string
     */
    public function getSignMethod():string;
}
