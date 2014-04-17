<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		UsualReply.php
*	description:	通用回复类
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
*	通用回复类
*
**/
class Reply_Model
{
	/**
	*	测试用返回信息
	*
	*	@param 无
	*	@return 返回信息数组
	*/
	public function testKeyWord($content)
	{
		$return['template'] = 'text';
		$return['Content'] = "这个是测试信息，当前正在测试:" . $content;
		return $return;
	}

	/**
	*	错误回复函数
	*
	*	@param 无
	*	@return 返回信息数组
	*/
	public function errReturn()
	{
		$return['template'] = 'text';
		$return['Content'] = "啊哦，很抱歉系统出故障了。";
		return $return;
	}


}




?>