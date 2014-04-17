<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		main.php
*	description:	子程序入口
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
*	主类，负责鉴别收到的信息，选择相应的数据并返回
*
**/
class Main
{
    //用于保存解析过的XML对象
    private $xml;

    //返回的信息数组，各处理函数只要返回模板类型即可，其余信息可在$return中自动获取
    private $return;

	function __construct()
	{

	}

    /**
    *    根据消息类型分发收到的消息
    *
    *    @param $postData 解析过的XML对象
    *    @return NULL
    */
	public function main($postData)
	{
        $this->xml = $postData;

        $GLOBALS['ServerName'] = $this->xml->ToUserName;
        $GLOBALS['UserName'] = $this->xml->FromUserName;

        $class = strtoupper($this->xml->MsgType) ."_Model";//根据消息类型构造相应的Model类
        $model = new $class();

        $this->return = $model->handle($this->xml);//调用默认的handle函数
        
        $view = new View($this->return['template']);//调用View模板

        //所有回复信息的共同部分
        $this->return["ToUserName"] = $this->xml->FromUserName;
        $this->return["FromUserName"] = $this->xml->ToUserName;
        $this->return["CreateTime"] = time();

        foreach ($this->return as $key => $value)
        {
            //对模板赋值
            $view->assign($key,$value);
        }

	}
}

?>