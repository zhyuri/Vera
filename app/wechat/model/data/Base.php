<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			base.php
*	description:	Data基类
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
* Model基类，负责通用的用户信息获取
*/
class Data_Base
{
	private static $resource = NULL;
	private static $userInfo = NULL;

	function __construct($resource)
	{
		self::$resource = $resource;
	}

	protected function getResource()
	{
		return self::$resource;
	}

	protected function setResource($_resource)
	{
		if(empty($_resource))
			return false;

		self::$resource = $_resource;
	}

	protected static function getUserInfo()
	{
		if (empty(self::$resource)) {
			return false;
		}

		if(!$db = Vera_Database::getInstance()) {
			return false;
		}

		$result = $db->select('vera_User', '*', array('wechat_id' => self::$resource['FromUserName']));

		if (!$result) {
			self::$userInfo = -1;
			return false;
		}
		self::$userInfo = $result[0];
		return $result[0];
	}

	private function _getInfo($info)
	{
		if (self::$userInfo == -1) {
			return false;
		}
		$ret = empty(self::$userInfo) ? self::getUserInfo() : self::$userInfo;
		return $ret[$info];

	}

	protected function getID()
	{
		return $this->_getInfo('ID');
	}

	protected function getStuNum()
	{
		return $this->_getInfo('xmu_num');
	}

	protected function getStuPass()
	{
		return $this->_getInfo('xmu_password');
	}

	protected function isLink()
	{
		return $this->_getInfo('xmu_isLinked');
	}

	protected function getYibanUid()
	{
		return $this->_getInfo('yiban_uid');
	}

	protected function getYibanAccess()
	{
		return $this->_getInfo('yiban_accessToken');
	}

	protected function getYibanRefresh()
	{
		return $this->_getInfo('yiban_refreshToken');
	}

}
?>
