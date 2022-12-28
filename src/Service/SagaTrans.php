<?php

namespace OA\DtmSdk\Service;

use OA\DtmSdk\Exception\ClientException as Exception;
use OA\DtmSdk\Constant\DtmConstant;
use OA\DtmSdk\Contracts\ITransWithSaga;

class SagaTrans extends TransBase implements ITransWithSaga
{
    // 事务执行顺序
    public $transSteps = [];


    /**
     * @param string $actionUrl
     * @param string $compensateUrl
     * @param array $postData
     * @return SagaTrans
     */
    public function withOperate(string $actionUrl, string $compensateUrl, array $postData = []): SagaTrans {
        $this->transSteps[] = [
            "action"     => $actionUrl,
            "compensate" => $compensateUrl
        ];
        $this->payloads[]   = json_encode($postData, JSON_UNESCAPED_UNICODE);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function submit(): bool {
        if (empty($this->transGid)) {
            throw new Exception('GidIsEmpty');
        }
        return $this->submitRequest([
            "gid"         => $this->transGid,
            "trans_type"  => DtmConstant::SagaTrans,
            "steps"       => $this->transSteps,
            "payloads"    => $this->payloads,
            "wait_result" => $this->waitResult
        ]);
    }

    public function abort() {
        if (empty($this->transGid)) {
            throw new Exception('GidIsEmpty');
        }
        return $this->abortRequest([
            "gid"         => $this->transGid,
            "trans_type"  => DtmConstant::SagaTrans,
            // "steps"       => $this->transSteps,
            // "payloads"    => $this->payloads,
            "wait_result" => $this->waitResult
        ]);
    }

}