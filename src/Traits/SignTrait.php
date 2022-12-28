<?php
/**
 * 签名-公共部分
 */
namespace OA\DtmSdk\Traits;

trait SignTrait
{
    /**
     * 校验签名
     * @author lynn
     * @DateTime 2022-01-27T18:23:17+0800
     * @param    array                    $data            待签名数据
     * @param    string                   $appSecret       签名密钥
     * @param    string                   $sign            待校验签名
     * @return   bool 是否验证通过
     */
    public function checkSign(array $data, string $appSecret, string $sign):bool
    {
        $curSign = $this->generateSign($data, $appSecret);
        if ($curSign && $curSign === $sign) {
            return true;
        }
        return false;
    }

    /**
     * 获取签名方式名
     * @author lynn
     * @DateTime 2022-01-30T09:48:32+0800
     * @return   string
     */
    public function getSignMethod():string
    {
        $className = get_class($this);
        $classNames = explode('\\', $className);
        $onlyName = array_pop($classNames);
        return lcfirst($onlyName);
    }

    /**
     * 获取待签名字符串
     * @author lynn
     * @DateTime 2022-01-27T18:23:17+0800
     * @param    array                    $data            待签名数据
     * @param    string                   $appSecret       签名密钥
     * @return   string 待签名字符串
     */
    private function getNeedSignString(array $data, string $appSecret):string
    {
        return $appSecret . $data['timestamp'] . $data['salt'];
    }

    /**
     * 已签名字符串编码处理
     * @author lynn
     * @DateTime 2022-01-27T18:23:17+0800
     * @param    string                   $stringToBeSigned       已签名字符串
     * @return   string 已签名字符串编码后
     */
    private function beSignedStringEncode(string $stringToBeSigned):string
    {
        return $stringToBeSigned;
    }
}
