<?php
/**
 * md5签名类
 */
namespace OA\DtmSdk\Sign;

use OA\DtmSdk\Contracts\SignInterface;
use OA\DtmSdk\Traits\SignTrait;

class Md5 implements SignInterface
{
    use SignTrait;

    /**
     * 生成签名
     * @author lynn
     * @DateTime 2022-01-27T18:23:17+0800
     * @param    array                    $data            待签名数据
     * @param    string                   $appSecret       签名密钥
     * @return   string 签名
     */
    public function generateSign(array $data, string $appSecret):string
    {
        $stringToBeSigned = $this->getNeedSignString($data, $appSecret);
        $beSignedString = md5($stringToBeSigned);
        return $this->beSignedStringEncode($beSignedString);
    }
}
