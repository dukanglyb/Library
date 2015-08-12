<?php

/**
 * Class IndexController
 */
class WjController extends JsonControllerBase
{


    public function indexAction()
    {
        if ($this->request->getMethod() == 'POST') {
            $array = array();
            $filenames = $this->uploadFile($array,array("file"),false);
            foreach($filenames as $filename){
                $today ='tempfile:'. date("yyyyMMdd");
                $this->redis->sAdd($today,$filename);
                $this->redis->expireAt($today,strtotime("+2 day"));
                $this->redis->sAdd('alltempfile',$filename);
            }
            return json_encode(array(
                'zhuangTaiMa' => 1,
                'tiShiXinXi' => '文件上传成功',
                'xiangYingShuJu'=>json_encode($filenames),
            ));
        }elseif($this->request->getMethod() == 'GET'){

        }
    }


}