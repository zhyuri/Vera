<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Memcached.php
*	description:	Vera缓存工具类
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
* 缓存工具类(目前使用Memcached)
*/
class Vera_Cache extends Memcached
{
    private static $conf = NULL;
    private static $instance = NULL;

	function __construct()
	{
        parent::__construct();
        $_conf = Vera_Conf::getConf('memcached');
        $this->_connect($_conf['host'], $_conf['port']);
        self::$conf = $_conf;
	}

    public static function getInstance()
    {
        if (self::$instance === NULL) {
            self::$instance = new Vera_Cache();
        }
        return self::$instance;
    }

    private function _connect($host , $port)
    {
        $servers = $this->getServerList();//防止反复的添加链接，实现链接重用
        if(is_array($servers)) {
            foreach ($servers as $server)
                if($server['host'] == $host and $server['port'] == $port)
                    return true;
        }
        return $this->addServer($host , $port);
    }

}







?>
