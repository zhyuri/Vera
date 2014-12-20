<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Base.php
*	description:	action基类
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
* action基类
*/
class Action_Base
{
	private static $resource = NULL;

	function __construct() {}

	protected static function getResource()
	{
		return self::$resource;
	}

	protected static function setResource($resource)
	{
		if(empty($resource))
			return false;

		self::$resource = $resource;
	}
}
?>
