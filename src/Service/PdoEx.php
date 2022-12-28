<?php

namespace OA\DtmSdk\Service;

use OA\DtmSdk\Contracts\IDatabase;
use PDO;

class PdoEx implements IDatabase
{
    private $dbW = null;

    /**
     * 初始化
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $dsn = 'mysql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'] . ';charset=' . $config['charset'];
        $username = $config['username'];
        $password = $config['password'];
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $config['charset'],
        );
        $this->dbW = new PDO($dsn, $username, $password, $options);
        if (isset($config['errmode'])) {
            $this->dbW->setAttribute(PDO::ATTR_ERRMODE, $config['errmode']);
        }
    }

    public function execute(string $sql, array $params):bool
    {
        $stmt = $this->dbW->prepare($sql);
        $res = $stmt->execute($params);
        if ($res) {
            return true;
        }
        return false;
    }

    public function rollback()
    {
        return $this->dbW->rollBack();
    }

    public function commit()
    {
        return $this->dbW->commit();
    }

    public function beginTrans()
    {
        return $this->dbW->beginTransaction();
    }
    
}
