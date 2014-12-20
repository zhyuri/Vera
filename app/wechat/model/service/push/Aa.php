<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Aa.php
*    description:     推送平台功能封装
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  推送平台
*/
class Service_Push_Aa
{
    private static $_resource = NULL;

    function __construct($resource = '')
    {
        self::$_resource = $resource;
    }

    public function pushToUser($id)
    {

    }

    public function pushToAll()
    {
        $cache = Vera_Cache::getInstance();
        $key = 'wechat_access';
        $queue = $cache->get($key);
        if ($cache->getResultCode() != Memcached::RES_SUCCESS) {
            return false;
        }

        $list = array();
        foreach ($log as $line) {
            preg_match_all('/createTime[.*?]/', $line, $result);
            $time = $result[0];
            if (time() > $time + 172800) {//超出48小时
                break;
            }
            preg_match_all('/userID[.*?]/', $line, $result);
            $list[] = $result[0];
        }

        $data = new Data_Func();
        foreach ($list as $each) {
            $this->push($each);
        }

    }

    public function ($value='')
    {
        # code...
    }
}

?>
