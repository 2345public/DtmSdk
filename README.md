[TOC]
# DTM 分布式事务客户端SDK文档
---
## 0. 简介
* dtm分布式事务客户端，包括配置、签名校验、重试等。
* 与dtm分布式事务中心通信。

## 1. 目录
```
├── README.md
├── composer.json
└── src
    ├── Base （单例基类）
    │   └── BaseClass.php
    ├── Config （配置模板）
    │   ├── client.php
    │   ├── errcodes.php
    │   └── sign.php
    ├── Constant （常量）
    │   └── DtmConstant.php
    ├── Contracts （接口合同模板）
    │   ├── ConfigInterface.php
    │   ├── FactoryInterface.php
    │   ├── IDatabase.php
    │   ├── ITransExcludeSaga.php
    │   ├── ITransWithSaga.php
    │   ├── SignInterface.php
    │   └── SingletonInterface.php
    ├── Exception（自定义异常）
    │   ├── BaseException.php
    │   └── ClientException.php
    ├── Laravel（laravel服务对接）
    │   ├── DtmClient.php
    │   └── ServiceProvider.php
    ├── Service（基础服务）
    │   ├── BarrierTrans.php
    │   ├── Config.php
    │   ├── Factory.php
    │   ├── SagaTrans.php
    │   └── TransBase.php
    ├── Sign（签名模块）
    │   ├── Md5.php
    │   ├── Sha1.php
    │   └── Sha256.php
    ├── Test（测试）
    │   ├── Demo.php
    │   └── Psr4Autoloader.php
    ├── Traits（公共部分）
    │   ├── HttpTrait.php
    │   ├── SignTrait.php
    │   ├── SingletonTrait.php
    │   └── UtilsTrait.php
    ├── Utils（工具）
    │   └── ToolsUtil.php
    ├── DtmClient.php（发起端入口）
    └── DtmServer.php（接收端入口）
```

## 2. 签名规则
* 字段：sign
* 算法：sha256
* 拼接：token+timestamp+salt
* 发起方式：post请求的url上，以参数的形式传递，例如：token=tttttttt ，则url为 http://a.b.com/c/d?* app=etimestamp=1669872494&* salt=ab8fesdf0sign=fa007b3de37717bff29e0b8cc0b7271d3e615870adbfac183c9168afd87c0e2b
* 参数说明：token为颁发给项目的授权码，每个项目都不同；timestamp为时间戳，精确到秒；salt为随机码；
