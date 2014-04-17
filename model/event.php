<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		event.php
*	description:	事件类型处理函数
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

include_once("BossModel.php");//包含入父类
/**
*	事件类型的处理函数
*
**/
class Event_Model extends Boss_Model
{
    private $xml;//由于事件的回复可能和用户当时情况相关（比如需要用户的位置）所以需要完整的xml包

    function __construct()
    {
        parent::__construct();
    }

	/**
	*	默认调用函数
	*
	*	@param $xml 获取到的解析后的xml对象
	*	@return 回复信息数组
	*/
	public function handle($xml)
	{
        $this->xml = $xml;
		$event = $xml->Event;

        // if($event == "unsubscribe")
        // {
        //     Register_Model::logOut();
        //     return ;
        // }

		$sql = "select * from EventReply where eventType = '{$event}' and serverID = '{$this->ServerName}'";

        return parent::usualReply($sql);
		
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
            $model = new $class(parent::$ServerName);
            if($type == 'route')//需要特殊参数的回复类型
            {
                $model->setParam($this->xml->Latitude,$this->xml->Longitude,$this->xml->Precision);//纬度、经度、精度
            }
            if($type == 'menu')//菜单点击按钮的回复类型
            {
                $model->setKey($this->xml->EventKey);
            }
            if($return = $model->handle($key))
            {
                return $return;
            }
        }
        return parent::defaultReply();
    }

}

?>