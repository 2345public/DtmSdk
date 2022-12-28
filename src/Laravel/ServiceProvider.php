<?php

namespace OA\DtmSdk\Laravel;

use OA\DtmSdk\DtmClient;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true; // 延迟加载服务

    /**
     * 注册服务
     * @author lynn
     * @DateTime 2022-02-07T15:07:02+0800
     * @return   void
     */
    public function register()
    {
        $this->app->singleton(DtmClient::class, function () {
            return new DtmClient();
        });

        $this->app->alias(DtmClient::class, 'OADtmClient');
    }

    /**
     * 门面服务
     * @author lynn
     * @DateTime 2022-02-07T15:07:07+0800
     * @return   void
     */
    public function provides()
    {
        return [DtmClient::class, 'OADtmClient'];
    }

    /**
     * 引导服务
     * @author lynn
     * @DateTime 2022-02-07T15:07:10+0800
     * @return   void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Config/client.php' => config_path('dtm-client.php')
        ]);
    }
}
