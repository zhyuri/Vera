<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		BossModel.php
*	description:	model父类，负责所有通用基础的函数
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
*	负责所有通用基础的model功能
*
**/
class Boss_Model
{
	public $db;
    public $ServerName;

	function __construct()
	{
		$this->db = new Database();
        $this->ServerName = $GLOBALS['ServerName'];
	}

    /**
    *    根据sql查询结果返回对应的结果
    *
    *    @param $sql SQL查询语句
    *    @return array 返回结果数组
    */
    protected function usualReply($sql)
    {
        try
        {
            if(!$this->db->query($sql))
            {
                throw new Exception("数据库或sql语句有问题", 1);
            }
            
            if(!$result = $this->db->getRow())
            {
                throw new Exception("没有匹配的关键字或serverID", 1);
            }

            if(in_array($result['replyType'], $GLOBALS['defaultReplyType']))
            {
                //对reply字段json解码，得到关联数组
                $reply = json_decode($result['reply'],true);
                $reply['template'] = $result['replyType'];
                return $reply;
            }
            else
            {
                return $this->specialReply($result['replyType'],$result['reply']);
            }
        }
        catch (Exception $e)
        {
            return $this->defaultReply();//如果有问题就返回默认值(比如没有这个关键字的记录)
        }
    }

    /**
    *     特殊内容的回复函数
    *
    *    @param $type 需要使用的返回数据类型
    *           $key 关键字
    *    @return 返回信息数组return
    */
    protected function specialReply($type,$key)
    {
        $class = $type . "_Model";

        if(class_exists($class))
        {
            $model = new $class($this->ServerName);
            if($return = $model->handle($key))
            {
                return $return;
            }
        }
        return $this->defaultReply;
    }

    /**
    *	默认的自动返回文字
    *
    *	@param 无
    *	@return 返回信息数组return
    */
    protected function defaultReply()
    {
    	try
    	{
    		$sql = "select defaultReply from ServerID where serverID = '{$this->ServerName}'";
            
        	if(!$this->db->query($sql))
                throw new Exception("找不到关键字或数据库错误", 1);
                
            if(!$result = $this->db->getRow())
                throw new Exception("找不到行", 1);

        	$return['Content'] = $result['defaultReply'];
    		
    	}
    	catch (Exception $e)
    	{
    		return $this->errReturn();//连默认值都有问题就返回错误信息
    	}
        
        $return['template'] = 'text';
        return $return;
    }

    /**
    *	默认的错误返回信息
    *
    *	@param 无
    *	@return 返回信息数组return
    */
    protected function errReturn()
    {
    	$return['Content'] = '很抱歉出了问题，请联系管理员。';
    	$return['template'] = 'text';

    	return $return;
    }
}


?>