<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Error.php
*	description:	微信内错误内容处理函数
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
        $log = 'file[' . $exception->getFile() .'] ';
        $log.= 'line[' . $exception->getLine() .'] ';
        $log.= 'message[' . $exception->getMessage(). '] ';
        Vera_Log::addErr($log);

		$resource = parent::getResource();
		if ($resource === NULL) {
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			$resource = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		}

		$msg = $exception->getMessage();
		$errMsg = empty($msg) ? parent::$commonConf['errMsg'] : $msg;

		$ret = "<xml>
        		    <ToUserName><![CDATA[".$resource['FromUserName']."]]></ToUserName>
        		    <FromUserName><![CDATA[".$resource['ToUserName']."]]></FromUserName>
        		    <CreateTime>".time()."</CreateTime>
        		    <MsgType><![CDATA[text]]></MsgType>
        		    <Content><![CDATA[".$errMsg."]]></Content>
        		</xml>";
        echo $ret;
        exit();
	}
}
?>
