<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		location.php
*	description:	位置信息返回函数
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

include_once("BossModel.php");//包含入父类
/**
*	位置信息处理函数
*
**/
class Location_Model extends Boss_Model
{
    private $x;
    private $y;

    function __construct()
    {
        parent::__construct();
    }

	/**
    *    文本信息处理函数
    *
    *    @param $xml 获取到的解析后的xml对象
    *    @return $return 返回所有信息的数组，必须包括$return['template']
    */
    public function handle($xml)
    {
        $this->x = $xml->Location_X;
        $this->y = $xml->Location_Y;

        $sql = "select * from Keyword where keyword = '{$xml->MsgType}' and serverID = '{$this->ServerName}'";
        
        return $this->usualReply($sql);
	}

	/**
    *     特殊内容的回复函数(重载)
    *
    *    @param $type 需要使用的返回数据类型
    *           $key 关键字
    *    @return 返回信息数组return
    */
    public function specialReply($type,$key)
    {
        $class = $type . "_Model";
        
        if(class_exists($class))
        {
            $model = new $class($this->ServerName);
            if($type = 'route')//需要特殊参数的回复类型
            {
                $model->setParam($this->x,$this->y);//纬度、经度、精度
            }
            if($return = $model->handle($key))
            {
                return $return;
            }
        }
        return $this->defaultReply;
    }
}
?>