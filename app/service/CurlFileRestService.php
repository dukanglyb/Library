<?php

/**
 * Created by PhpStorm.
 * User: xiang
 * Date: 14-12-30
 * Time: 下午2:19
 */
class CurlFileRestService extends BaseCurlClient
{

    /**
     * 设置超时时间
     * @var
     */
    private $timeout;
    private $prefix_url;
    private $tfsConfig;
    /**
     * 构造函数初始化
     */
    function __construct()
    {
        $this->tfsConfig = $this->config->server['tfs'];
        $this->serviceResource =  "http://".$this->tfsConfig['nginx-tfs']['ip'].":".$this->tfsConfig['nginx-tfs']['port'];
        $this->prefix_url = '/v2/'.$this->tfsConfig['appkey'].'/'.$this->tfsConfig['appid'];
    }



    /**
     * 析构函数释放curl
     */
    function __destruct()
    {
//        if($curl){
//            curl_close($curl);
//        }
    }
    public function createDir($uid,$dir_name){
       return $this->performPostRequest($this->prefix_url."/$uid/dir/$dir_name",null);
    }

    public function listDir($uid){
        return $this->performGetRequest('/v2/'.$this->tfsConfig['appkey'].'/metadata/'.$this->tfsConfig['appid'].'/$uid/dir/');
    }

    public function initCurl(){
        $curl = curl_init();

        $this->timeout = $this->getDefaultTimeout();
        // 设置通用参数
        curl_setopt_array(
            $curl,
            array(
                // 从 curl_exec 返回应答体
                CURLOPT_RETURNTRANSFER => true,
                // 获取二进制输出
                CURLOPT_BINARYTRANSFER => true,
                // 从 curl_getinfo 中获取
                CURLOPT_HEADER => false
            )
        );
        return $curl;
    }

    /**
     * 处理Get请求
     * @param $url
     * @return mixed
     */
    public function  performGetRequest($url)
    {
        $curl = $this->initCurl();
        if ($this->timeout === false || $this->timeout <= 0.0) {
            // 使用默认的超时时间
            $this->timeout = $this->getDefaultTimeout();
        }
        //获取对应地址
        $content_type = "application/json;charset=UTF-8";
        curl_setopt_array($curl, array(
            // 确保返回的有Body
            CURLOPT_NOBODY => false,
            // GET 方式传送数据
            CURLOPT_HTTPGET => true,
            // 设置 URL
            CURLOPT_URL => $this->serviceResource . $url,
            // 设置 content type
            CURLOPT_HTTPHEADER => array("Content-Type: {$content_type}"),
            // 设置超时时间
            CURLOPT_TIMEOUT => $this->timeout
        ));

        //处理请求，调用restful Service
        $response_body = curl_exec($curl);
        if ($response_body === false) {
            $this->logError(curl_error($curl));
        }
        //获取相关信息
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//         $content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        //请求后台服务时候失败后返回

        if(!preg_match('/^\d{3}$/',$status_code)){
            $response_body = json_encode(array(
                'zhuangTaiMa'=>-900,
                'tiShiXinXi'=>'后台HTTP错误',
                'xiangYingShuJu'=>array(
                    'status'=>$status_code
                )
            ));
        }
        curl_close($curl);
        return $response_body;
    }

    /**
     * 处理Post请求
     * @param $url
     * @param $data
     * @return mixed
     */
    public function performPostRequest($url, $data)
    {
        $curl = $this->initCurl();
        //获取对应地址
        if ($this->timeout === false || $this->timeout <= 0.0) {
            // 使用默认的超时时间
            $this->timeout = $this->getDefaultTimeout();
        }
        curl_setopt_array($curl, array(
            CURLOPT_HEADER=>false,
            //  POST 方式传送数据
            CURLOPT_POST => true,
            // 设置 URL
            CURLOPT_URL => $this->serviceResource . $url,
            // 设置 post 数据
            CURLOPT_POSTFIELDS => $data,
            // 设置超时时间
            CURLOPT_TIMEOUT => $this->timeout
        ));
        // 执行请求
        $response_body = curl_exec($curl);
        if ($response_body === false) {
            $this->logError(curl_error($curl));
        }
        // 获取curl信息
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //请求后台服务时候失败后返回
        if(!preg_match('/^\d{3}$/',$status_code)){
            $response_body = json_encode(array(
                'zhuangTaiMa'=>-900,
                'tiShiXinXi'=>'后台HTTP错误',
                'xiangYingShuJu'=>array(
                    'status'=>$status_code
                )
            ));
        }
        curl_close($curl);
        return $response_body;
    }


    /**
     * 处理Post请求
     * @param $url
     * @param $data
     * @return mixed
     */
    public function performPutRequest($url, $data)
    {
        $curl = $this->initCurl();
        //获取对应地址
        $content_type = "application/json;charset=UTF-8";
        if ($this->timeout === false || $this->timeout <= 0.0) {
            // 使用默认的超时时间
            $this->timeout = $this->getDefaultTimeout();
        }
        $method = 'PUT';
        $header = array(
            "X-HTTP-Method-Override: $method",
            "Content-type:$content_type");

        curl_setopt_array($curl, array(
            // 确保返回的有Body
            CURLOPT_RETURNTRANSFER => 1,
            //  PUT 方式传送数据
            CURLOPT_CUSTOMREQUEST => $method,
            // 设置 URL
            CURLOPT_URL => $this->serviceResource . $url,
            // 设置 post 数据
            CURLOPT_POSTFIELDS => json_encode($data),
            // 设置 content type
            CURLOPT_HTTPHEADER =>$header,
            // 设置超时时间
            CURLOPT_TIMEOUT => $this->timeout
        ));
        // 执行请求
        $response_body = curl_exec($curl);
        if ($response_body === false) {
            $this->logError(curl_error($curl));
        }
        // 获取curl信息
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//         $content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        //请求后台服务时候失败后返回
        if(!preg_match('/^\d{3}$/',$status_code)){
            $response_body = json_encode(array(
                'zhuangTaiMa'=>-900,
                'tiShiXinXi'=>'后台HTTP错误',
                'xiangYingShuJu'=>array(
                    'status'=>$status_code
                )
            ));
        }
        curl_close($curl);
        return $response_body;

    }

    /**
     * 处理Delete请求
     * @param $url
     * @param $data
     * @return mixed
     */
    public function performDeleteRequest($url, $data)
    {
        $curl = $this->initCurl();
        //获取对应地址
        $content_type = "application/json;charset=UTF-8";
        if ($this->timeout === false || $this->timeout <= 0.0) {
            // 使用默认的超时时间
            $this->timeout = $this->getDefaultTimeout();
        }
        $method = 'DELETE';
        $header = array(
            "X-HTTP-Method-Override: $method",
            "Content-type:$content_type");

        curl_setopt_array($curl, array(
            // 确保返回的有Body
            CURLOPT_RETURNTRANSFER => 1,
            //  PUT 方式传送数据
            CURLOPT_CUSTOMREQUEST => $method,
            // 设置 URL
            CURLOPT_URL => $this->serviceResource . $url,
            // 设置 post 数据
            CURLOPT_POSTFIELDS => json_encode($data),
            // 设置 content type
            CURLOPT_HTTPHEADER =>$header,
            // 设置超时时间
            CURLOPT_TIMEOUT => $this->timeout
        ));
        // 执行请求
        $response_body = curl_exec($curl);
        if ($response_body === false) {
            $this->logError(curl_error($curl));
        }
        // 获取curl信息
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//         $content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
        //请求后台服务时候失败后返回
        if(!preg_match('/^\d{3}$/',$status_code)){
            $response_body = json_encode(array(
                'zhuangTaiMa'=>-900,
                'tiShiXinXi'=>'后台HTTP错误',
                'xiangYingShuJu'=>array(
                    'status'=>$status_code
                )
            ));
        }
        curl_close($curl);
        return $response_body;

    }



}