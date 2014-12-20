<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Autoload.php
*	description:	 自动加载魔术方法
*
*	@author Yuri
*	@license Apache v2 License
*
**/


/**
* 自动加载类
*/
class Vera_Autoload
{
	private static $oldApp = NULL;

	function __construct()
	{

	}

	public static function init()
	{
		spl_autoload_register('Vera_Autoload::_loadClass');
	}

	public static function isExists($name = '')
	{
		if ($name == '') {
			return false;
		}
		return class_exists($name);
	}

	public static function changeApp($app = '')
	{
		if (empty($app)) {
			return false;
		}
		Vera_Log::addNotice('change app to '. $app);
		self::$oldApp = $GLOBALS['APP_NAME'];
		$GLOBALS['APP_NAME'] = $app;
		Vera_Conf::resetBuffer();
		return true;
	}

	public static function reverseApp()
	{
		if (!self::$oldApp) {
			Vera_Log::addWarning('reverse app failed, no oldApp found');
			return false;
		}
		$GLOBALS['APP_NAME'] = self::$oldApp;
		Vera_Log::addNotice('reverse app to '. self::$oldApp);
		self::$oldApp = NULL;
		Vera_Conf::resetBuffer();
		return true;
	}

	private static function _loadClass($className)
	{
		$appRoot = SERVER_ROOT . "app/" . $GLOBALS['APP_NAME'];

		$filePath = explode('_', $className);

		switch (array_shift($filePath)) {
			case 'Action':
				$nextDir = '/action/';
				break;
			case 'Data':
				$nextDir = '/model/data/';
				break;
			case 'Service':
				$nextDir = '/model/service/';
				break;
			case 'Vera':
				$appRoot = SERVER_ROOT;
				$nextDir = '/tools/';
				break;
			case 'Smarty':
				return smartyAutoload($className);//使用Smarty自带的Autoload函数加载Smarty引擎相关的类
				break;
			case 'View':
				$nextDir = '/view/';
				break;
			case 'Library':
				$nextDir = '/library/';
				break;
			default:
				Vera_Log::addErr('unknown classname ' . $className);
				exit();
		}
		$classPath = $appRoot . $nextDir;
		$file = array_pop($filePath);
		if (count($filePath) != 0) {
			foreach ($filePath as $each) {
				$classPath.= strtolower($each) . "/";
			}
		}
		$classPath.= $file . ".php";

		if (file_exists($classPath)) {
			include_once($classPath);
		}
		else{
			Vera_Log::addErr($className . ' not found');
			Vera_Log::addNotice('classPath',$classPath);
			return false;
		}

	}
}


?>
