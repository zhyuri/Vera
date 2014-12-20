<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Base.php
*	description:	微信action基类
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
* 微信action基类
*/
class Action_Base
{
	private static $resource = NULL;

	protected static $commonConf = NULL;
	
	function __construct($resource)
	{
		self::$resource = $resource;
		self::$commonConf = Vera_Conf::getAppConf('common');
	}

	protected static function getResource()
	{
		return self::$resource;
	}

	protected function setResource($resource)
	{
		if(empty($resource))
			return false;

		self::$resource = $resource;
	}
}
?>