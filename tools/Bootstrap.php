<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Init.php
*	description:	Vera 初始化类，实现 autoload 函数并调起路由
*
*	@author Yuri
*	@license Apache v2 License
*
**/
include_once('Autoload.php');

/**
* Vera 初始化类
*/
class  Vera_Bootstrap
{
	private static $Log = NULL;//在整个生命周期中保持住Log类

	function __construct()
	{
		date_default_timezone_set('Asia/Shanghai');

		//应用的根目录就是index.php的父目录
		define("SERVER_ROOT", $_SERVER['DOCUMENT_ROOT'] . '/');

		$url = parse_url($_SERVER['REQUEST_URI']);
		$temp = explode('/', $url['path']);

		if (!empty($temp[1])) {
			$GLOBALS['APP_NAME'] = $temp[1];
		}
		else{
			$GLOBALS['APP_NAME'] = 'cms';
		}

		define("APP_DIR", SERVER_ROOT . 'app/' . $GLOBALS['APP_NAME'] . '/');

		if (!empty($temp[2])) {
			$action = array_slice($temp, 2);
			$name = '';
			foreach ($action as $each) {
				$name.= ucfirst($each) . '_';
			}
			define("ACTION_NAME", rtrim($name,'_'));
		}
		else{
			define("ACTION_NAME", 'Index');
		}

        define('SMARTY_DIR',SERVER_ROOT . 'tools/smarty/');//定义Smarty模板引擎路径
	}

	/**
	 * 初始化环境，返回action层对应类的实例
	 * @return class 触发到的action层对应类
	 */
	public function init()
	{
		Vera_Autoload::init();
		$router = new Vera_Router();

		if (!Vera_Router::isApp()) {//如果app未开启，停止运行
			exit();
		}

		if (Vera_Autoload::isExists('Action_Error::run')) {
			set_exception_handler('Action_Error::run');//最高级的异常捕获，统一显示为每个app自定的错误
		}

		self::$Log = new Vera_Log;
		self::$Log->init();

		if (Vera_Autoload::isExists('Action_Auth')) {
			if (!Action_Auth::run()) {
				Vera_Log::addNotice('auth','fail');
				exit();
			}
			Vera_Log::addNotice('auth','success');
		}

		return $router->getAction();
	}
}



?>
