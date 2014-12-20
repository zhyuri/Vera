<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Error.php
*	description:	错误内容处理函数
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
* 错误内容处理类
*/
class Action_Error extends Action_Base
{

	function __construct($resource)
	{
		parent::__construct($resource);
	}

	public static function run($exception)
	{
        $log = 'Message: ' . $exception->getMessage();
        Vera_Log::addErr($log);
        return true;
	}
}
?>
