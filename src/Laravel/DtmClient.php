<?php

namespace OA\DtmSdk\Laravel;

class DtmClient extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'OADtmClient';
    }
}
