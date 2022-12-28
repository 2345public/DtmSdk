<?php

namespace OA\DtmSdk\Contracts;

interface IDatabase
{
    public function execute(string $sql, array $params):bool;

    // public function query(string $query): bool;

    public function rollback();

    public function commit();

    public function beginTrans();
}