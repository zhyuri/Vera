<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			router.php
*	description:	 路由功能实现
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
* 路由类
*/
class Vera_Router
{
	private static $routerMap;
	private static $appMap;

	function __construct()
	{
		$conf = Vera_Conf::getConf('router');
		self::$routerMap = $conf['map'];
		self::$appMap = $conf['app'];
	}

	/**
	 * 根据url请求，产生对应的action实例
	 * @return class action实例
	 */
	public function getAction()
	{
		if(!self::isApp())
		{
			exit();
		}

		$className = ACTION_NAME;
		$arg = NULL;

		if (!empty(self::$routerMap[$GLOBALS['APP_NAME']])) {
			$className = call_user_func_array(array('Vera_Router',self::$routerMap[$GLOBALS['APP_NAME']]), array(&$arg));
		}

		return $this->_createClass($className,$arg);
	}

	/**
	 * 检查是否为合法的App
	 */
	public static function isApp()
	{
		if (isset(self::$appMap[$GLOBALS['APP_NAME']]) && self::$appMap[$GLOBALS['APP_NAME']] == '1') {
			return true;
		}
		return false;
	}

	/**
	 * 根据名称和参数创建一个类
	 * @param  string $className action类的名称
	 * @param  mixed $arg       参数
	 * @return class            返回一个类实例
	 */
	private function _createClass($className,$arg = NULL)
	{
		$className = "Action_" . $className;
		$class = new $className($arg);
		if ($class == NULL) {
			Vera_Log::addErr('cannot create class '.$className);
			exit();
		}
		return $class;
	}

	/**
	 * 微信特有路由
	 * @return class action实例
	 */
	private function wechatRouter(&$arg)
	{
		if (isset($GLOBALS["HTTP_RAW_POST_DATA"]) && !empty($GLOBALS["HTTP_RAW_POST_DATA"])) {
			//解析XML包
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			$arg = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

			Vera_Log::addNotice('userID',$arg['FromUserName']);
			Vera_Log::addNotice('serverID',$arg['ToUserName']);
			Vera_Log::addNotice('createTime',$arg['CreateTime']);
			Vera_Log::addNotice('msgType',$arg['MsgType']);
			if (isset($arg['MsgId'])) {
				Vera_Log::addNotice('msgId',$arg['MsgId']);
			}

			return ucfirst($arg['MsgType']);
		}
		else if (isset($_GET["echostr"])){//初次接入微信号
			echo $_GET["echostr"];
			exit();
		}
		else {//异常访问
			$url="http://www.baidu.com";
			header("Location: $url");
			exit();
		}
	}
}
?>
