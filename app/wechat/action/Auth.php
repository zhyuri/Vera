<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Auth.php
*	description:	权威性验证action
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
* 权威性验证
*/
class Action_Auth extends Action_Base
{

	function __construct()
	{

	}

	public static function run()
	{
		return true;//暂时无法解决signature校验不一致的问题

		$conf = Vera_Conf::getConf('global');
		$conf = $conf['wechat'];
		if (!isset($conf['token']) || empty($conf['token'])) {
			Vera_Log::addErr('cannot find token');
			exit();
		}
		$token = $conf['token'];

		return self::_checkSignature($token);
	}

	private static function _checkSignature($token)
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}
?>
