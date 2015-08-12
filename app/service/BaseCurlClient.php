<?php

/**
 * Created by PhpStorm.
 * User: xiang
 * Date: 14-12-30
 * Time: 下午2:23
 */
abstract class BaseCurlClient extends \Phalcon\DI\Injectable
{
    private $default_timeout = false;

    /**
     * 创建默认时间
     * @return bool|int
     */
    public function getDefaultTimeout()
    {
        //  获取系统的默认时间
        if ($this->default_timeout === false) {
            $this->default_timeout = (int)ini_get('default_socket_timeout');
            // 再次检查
            if ($this->default_timeout <= 0) {
                $this->default_timeout = 60;
            }
        }
        return $this->default_timeout;
    }

    /**
     * 记录错误信息
     * @param $errorData
     */
    public function  logError($errorData)
    {
        //记录错误信息
    }

    /**
     * Set the current default timeout for all HTTP requests
     *
     * @param float $timeout
     */
    public function setDefaultTimeout($timeout)
    {
        $timeout = (float)$timeout;
        if ($timeout >= 0) {
            $this->default_timeout = $timeout;
        }
    }

    /**
     * 处理Get请求
     * @param $url
     * @return mixed
     */
    abstract public function performGetRequest($url);

    /**
     * 处理Post请求
     * @param $url
     * @param $data
     * @return mixed
     */
    abstract public function performPostRequest($url, $data);


    /**
     * 处理put请求
     * @param $url
     * @param $data
     * @return mixed
     */
    abstract public function performPutRequest($url, $data);
} 