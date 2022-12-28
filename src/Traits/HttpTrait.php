<?php

namespace OA\DtmSdk\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use OA\DtmSdk\Constant\DtmConstant;
use OA\DtmSdk\Exception\ClientException as Exception;

trait HttpTrait
{
    protected $client = null;
    //失败重试次数
    private $retryCount = 0;

    /**
     * 获取http客户端对象
     *
     * @return Client
     */
    protected function client(): Client {
        if (empty($this->client)) {
            $this->client = new Client(array_merge([
                "verify"  => false,
                "timeout" => 60
            ], $this->config));    
        }
        return $this->client;
    }

    /**
     * get请求
     *
     * @param string $url
     * @return object
     */
    protected function get(string $url)
    {
        $url2 = $this->combineUrl($url);
        return $this->getOrigin($url2);
    }

    /**
     * get原始请求
     *
     * @param string $url
     * @return object
     */
    private function getOrigin(string $url)
    {
        $runCount  = $this->retryCount + 1;
        do {
            try {
                $body     = $this->client()->get($url)->getBody()->getContents();
                $response = json_decode($body, false);
                if (strpos($body, DtmConstant::Failure) !== false) {
                    throw new Exception('GetUrlFailed', [$url, $response->message]);
                }
                break;
            } catch (RequestException $e) {
                $runCount--;
            } catch (\Throwable $e) {
                throw $e;
            }
        } while ($runCount > 0);
        if ($runCount <= 0) {
            throw $e;
        }
        return $response;
    }

    /**
     * post的json请求
     *
     * @param string $url
     * @param array $jsonData
     * @return object
     */
    protected function postJson(string $url, array $jsonData)
    {
        $url2 = $this->combineUrl($url);
        $options = [
            "json" => $jsonData,
        ];
        return $this->postOrigin($url2, $options);
    }

    /**
     * post的原始请求
     *
     * @param string $url
     * @param array $options
     * @return object
     */
    protected function postOrigin(string $url, array $options)
    {
        $runCount  = $this->retryCount + 1;
        do {
            try {
                $body     = $this->client()->post($url, $options)->getBody()->getContents();
                $response = json_decode($body, false);
                if (strpos($body, DtmConstant::Failure) !== false) {
                    throw new Exception('PostUrlFailed', [$url, $response->message]);
                }
                break;
            } catch (RequestException $e) {
                $runCount--;
            } catch (\Throwable $e) {
                throw $e;
            }
        } while ($runCount > 0);
        if ($runCount <= 0) {
            throw $e;
        }
        return $response;
    }
}