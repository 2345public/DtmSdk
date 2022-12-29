<?php

namespace OA\DtmSdk\Service;

use Exception;
use OA\DtmSdk\Constant\DtmConstant;
use OA\DtmSdk\Contracts\IDatabase;

class BarrierTrans
{
    public $transType;
    public $transGid;
    public $branchId;
    public $operate;
    public $barrierId = 0;
    private $database = null;
    //默认配置文件名
    private $configName = 'client';

    public function __construct(array $query, array $config = []) {
        $configDefault = Config::get($this->configName);
        $config = array_merge($configDefault['barrier'], $config);
        $this->switch = $config['switch'];
        if ($this->switch) {
            $this->transType = $query["trans_type"];
            $this->transGid  = $query["gid"];
            $this->branchId  = $query["branch_id"];
            $this->operate   = $query["op"];
            $this->database = new PdoEx($config);    
        }
    }

    /**
     * @return mixed
     */
    public function getTransGid() {
        return $this->transGid;
    }

    /**
     * @param mixed $transGid
     */
    public function setTransGid($transGid) {
        $this->transGid = $transGid;
    }

    /**
     * @return mixed
     */
    public function getBranchId() {
        return $this->branchId;
    }

    /**
     * @param mixed $branchId
     */
    public function setBranchId($branchId) {
        $this->branchId = $branchId;
    }

    /**
     * @return mixed
     */
    public function getOperate() {
        return $this->operate;
    }

    /**
     * @param mixed $operate
     */
    public function setOperate($operate) {
        $this->operate = $operate;
    }

    /**
     * @return mixed
     */
    public function getTransType() {
        return $this->transType;
    }

    /**
     * @param mixed $transType
     */
    public function setTransType($transType) {
        $this->transType = $transType;
    }

    /**
     * @param callable $callback
     * @return bool
     * @throws Exception
     */
    public function call(callable $callback): bool {
        if (!$this->switch) {
            try {
                $success = $callback($this->database);
                if ($success) {
                    return true;
                }
                return false;
            } catch (\Throwable $e) {
                throw $e;
            }
        }
        $this->database->beginTrans();
        try {
            $this->barrierId++;
            $barrierId     = sprintf("%02d", $this->barrierId);
            $originType    = [
                DtmConstant::ActionCancel     => DtmConstant::ActionTry,
                DtmConstant::ActionCompensate => DtmConstant::Action
            ][$this->operate];
            $originAffect  = $this->insertBarrier($this->database, $originType, $barrierId);
            $currentAffect = $this->insertBarrier($this->database, $this->operate, $barrierId);
            $actionIgnore  = $this->operate == DtmConstant::ActionCancel || $this->operate == DtmConstant::ActionCompensate;
            if ($actionIgnore && $originAffect || $currentAffect == false) {
                $this->database->commit();
                return true;
            }
            $success = $callback($this->database);
            if (!$success) {
                $this->database->rollback();
                return false;
            }
            $this->database->commit();
        } catch (\Throwable $e) {
            $this->database->rollback();
            throw $e;
        }
        return true;
    }

    private function insertBarrier(IDatabase $database, $originType, $barrierId): bool {
        // $sql = "insert ignore into dtm_barrier.barrier(trans_type, gid, branch_id, op, barrier_id, reason) ";
        // $sql .= "values('{$this->transType}','{$this->transGid}','{$this->branchId}','{$originType}','{$barrierId}','{$this->operate}')";
        $sql = "insert ignore into barrier(trans_type, gid, branch_id, op, barrier_id, reason) ";
        $params = [$this->transType, $this->transGid, $this->branchId, $originType, $barrierId, $this->operate];
        $placeHolders = implode(',', array_fill(0, count($params), '?'));
        $sql .= 'values(' . $placeHolders . ')';
        return $database->execute($sql, $params);
    }
}
