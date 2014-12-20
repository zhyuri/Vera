<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Func.php
*    description:     推送平台功能封装
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  推送功能封装
*/
class Data_Wechat_Push_Func extends Data_Wechat_Base
{
    private $accessToken;
    private $_resource;//用于推送的内容

    function __construct($resource) {
        $this->$_resource = $resource;
    }

    private function _getReady()
    {
        $data = new Data_Wechat_Base();
        $this->accessToken = $data->accessToken;
    }

    public function push($openid)
    {
        $accessToken = $this->accessToken;
        if (!$accessToken) {
            $accessToken = $this->_getReady();
        }


    }

    public function addPushQueue($openid)
    {
        $cache = Vera_Cache::getInstance();
        $key = 'push_queue';
    }

    public function getPushQueue()
    {
        $cache = Vera_Cache::getInstance();
        $key = 'push_queue';
        $queue = $cache->get($key);
        if ($cache->getResultCode() == Memcached::RES_SUCCESS) {
            return $queue;
        }
        else {
            return false;
        }
    }
}

?>
