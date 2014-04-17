<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		lucky.php
*	description:	抽奖模块
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
*	抽奖模块处理类
*
**/
class Lucky_Model
{
    public $db;

	public $ServerName;
	
	function __construct()
	{
		$this->ServerName = $GLOBALS['ServerName'];

        $this->db = new Database();
	}

	/**
    *	默认调用函数
    *
    *	@param 无
    *	@return 回复信息数组
    */
    public function handle()
    {
    	if(!($info = $this->getLuckyInfo()))
    		return $this->errReturn();

		foreach ($info['prize'] as $key => $val)
		{ 
		    $arr[$val['order']] = $val['chance']; 
		}

		$id = $this->tryLucky($arr);//得到中奖id

		$return['template'] = 'text';
		$return['Content'] = $info['prize'][$id]['content'];
		if($id != 0)//如果中奖了，附加上备注信息
		{
			$return['Content'].= $info['remark'];
		}

		return $return;
    }

    /**
    *	抽奖函数
    *
    *	@param 中奖信息数组
    *	@return bool 中奖与否
    */
    private function tryLucky($chanceArr)
    {
    	$result = ''; 

    	//概率数组的总概率精度
    	$proSum = array_sum($chanceArr); 

    	//概率数组循环
    	foreach ($chanceArr as $key => $proCur)
    	{ 
    	    $randNum = mt_rand(1, $proSum); 
    	    if ($randNum <= $proCur)
    	    { 
    	        $result = $key; 
    	        break; 
    	    }
    	    else
    	    { 
    	        $proSum -= $proCur; 
    	    } 
    	} 
    	unset ($proArr); 

    	return $result;
    }

    /**
    *	获取该订阅号的抽奖信息
    *
    *	@param 无
    *	@return 中奖概率和奖品等信息
    */
    private function getLuckyInfo()
    {
    	$sql = "select info from Lucky_Info where serverID='{$this->ServerName}'";

    	$this->db->query($sql);
        if($result = $this->db->getRow())
            return json_decode($result['info'],true);
        else
            return FALSE;
    }

    /**
    *	错误信息返回
    *
    *	@param 无
    *	@return Array 返回信息
    */
    private function errReturn()
    {
    	$return['template'] = 'text';
    	$return['Content'] = "很抱歉抽奖功能出了问题。\n请稍后再试。";
    	return $return;
    }
}

?>