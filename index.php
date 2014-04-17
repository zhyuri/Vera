<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		index.php
*	description:	微信后台服务器入口文件
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

//应用的根目录就是index.php的父目录
define("SERVER_ROOT", dirname(__FILE__));

//微信用TOKEN
define("TOKEN", "");

// 验证消息是否来自微信服务器(使用接口测试工具时，由于没有TOKEN，需禁止此验证)
require_once('check.php');
$wechatObj = new wechatCallbackapiTest();
if(!$wechatObj->valid())
{
	exit("欢迎关注 '代码仔的实验室' ");
}

//引入数据库类
require_once("database.php");

//引入配置文件
require_once("configure.php");

//解析XML包
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$POSTobj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA); 

/**
 * 引入router.php
 */
require_once('router.php');

?>