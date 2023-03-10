<?php

namespace OA\DtmSdk\Contracts;

/**
 * Interface ITransCommon
 * @package sett\transaction\contract
 * tcc|xa|msg
 */
interface ITransExcludeSaga
{

    public function prepare();

    public function submit();

    public function abort();
}