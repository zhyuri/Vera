<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Conf.php
*	description:	 配置读取文件
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
*  读取配置实用工具
*/
class Vera_Conf
{
	//配置缓存机制
	private static $buffer = array(
						'path' => NULL,
						'content' => NULL
					);

	function __construct() {}

	/**
	 * 重置配置缓存
	 * @return bool 重置是否成功
	 */
	public static function resetBuffer()
	{
		self::$buffer = array(
						'path' => NULL,
						'content' => NULL
					);
		return true;
	}

	/**
	 * 设置某APP配置内容
	 * @param array $arr  配置文件数组
	 * @param string $name 配置文件名
	 * @param string $app  App名
	 */
	public static function setAppConf($arr, $name, $app = NULL)
	{
		if (empty($arr) || empty($name)) {
			Vera_Log::addWarning('set conf input error');
			return false;
		}
		if ($app === NULL) {
			$app = $GLOBALS['APP_NAME'];
		}

		$path = SERVER_ROOT .'conf/'. $app . '/' . $name . '.conf';
		if (!file_exists($path)) {
			Vera_Log::addWarning('set conf file not exists');
			return false;
		}

		return file_put_contents($path, json_encode($arr,JSON_UNESCAPED_UNICODE), LOCK_EX);
	}

	/**
	 * 获取全局配置
	 * @param  string $name 配置文件名称
	 * @return array       配置内容
	 */
	public static function getConf($name)
	{
		$path = SERVER_ROOT .'conf/'. $name . '.conf';
		$ret = self::_getFile($path);

		if(!$ret){
			Vera_Log::addErr('prase conf '.$path.' error');
			return false;
		}
		return $ret;

	}

	/**
	 * 获取某App配置
	 * @param  string $name 配置文件名
	 * @param  string $app  App名称
	 * @return array       配置内容
	 */
	public static function getAppConf($name, $app = NULL)
	{
		if ($app === NULL) {
			$app = $GLOBALS['APP_NAME'];
		}

		$path = SERVER_ROOT .'conf/'. $app . '/' . $name . '.conf';
		$ret = self::_getFile($path);

		if(!$ret){
			Vera_Log::addErr('prase conf '.$path.' error');
			return false;
		}
		return $ret;
	}

	/**
	 * 获取配置文件并解析
	 * @param  string $path 配置文件全路径
	 * @return array       配置内容
	 */
	private static function _getFile($path)
	{
		if (self::$buffer['path'] == $path) {//检查缓存
			return self::$buffer['content'];
		}
		if (file_exists($path)) {
			$content = file_get_contents($path);
			$ret = self::_praseJson($content);

			self::$buffer['path'] = $path;
			self::$buffer['content'] = $ret;
		}
		else
			$ret = false;
		return $ret;
	}

	/**
	 * 解析配置文件
	 * @param  string $content 配置文件内容
	 * @return array       配置数组
	 */
	private static function _praseJson($content = NULL)
	{
		if ($content === NULL) {
			return false;
		}

		$ret = json_decode($content,true);
		return $ret;
	}
/*
	//自定义conf格式暂时未予实现

	private static function _parseContent($content)
	{
		$ret = array();
		$lines = split('\n', $content);
		$level = 0;
		foreach ($lines as $line) {
			$line = trim($line);
			if(empty($Line))
				continue;

			$temp = self::_parseLine($line);

			if(isset($temp['level'])){
				if ($temp['level'] > $level) {
					end($ret);
					$ret[key($ret)][$temp['name']] = array();
				}
				elseif ($temp['level'] > $level) {
					# code...
				}
			}
			else if(isset($temp['key'])){

			}
			else
				return false;
		}
		return $ret;
	}

	private static function _parseLine($line)
	{
		if ('[' == $line[0]) {
			$name = strrchr($line, '.');
			if ($name == false){
				$ret['level'] = 0;
				$name = $line;
			}
			else
				$ret['level'] = strlen($line) - strlen($name);
			$ret['name'] = substr($name, 1, -1);//去除开头的 '.'
		}
		else{
			$content = split(':', $line);
			if(count($content) != 2)
				return false;
			$ret['key'] = trim($content[0]);
			$ret['value'] = trim($content[1]);
		}
		return $ret;
	}
*/
}

?>
