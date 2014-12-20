<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            View.php
*    description:    Vera框架View层统一模板引擎
*
*    @author Yuri
*    @license Apache v2 License
*
**/

require_once(SMARTY_DIR . 'Smarty.class.php');
/**
* 统一模板引擎
*/
class Vera_View extends Smarty
{

    function __construct($debug)
    {
        parent::__construct();

        $this->setTemplateDir(SERVER_ROOT . 'templates/');
        $this->setCompileDir(SERVER_ROOT .'cache/smarty/templates_c/'. $GLOBALS['APP_NAME'] .'/');
        $this->setConfigDir(SERVER_ROOT . 'templates/' . $GLOBALS['APP_NAME'] .'/conf/');//Smarty配置文件
        $this->setCacheDir(SERVER_ROOT .'cache/smarty/cache/'. $GLOBALS['APP_NAME'] .'/');

        $this->setCaching(Smarty::CACHING_LIFETIME_SAVED);// 让每个模板缓存的过期时间都可以在display执行前单独设置。

        if ($debug) {//开启调试模式
            $this->caching = Smarty::CACHING_OFF;//强制刷缓存
            $this->debugging = true;
            Vera_Log::addNotice('isDebug','1');
        }
        else {
            $this->force_compile = false;
            $this->setCompileCheck(false);
        }

        $this->assign('base', '/templates/');//view文件夹根目录

    }

    public function dailyBackground()
    {
        $centerColor = array(
            '#99ffff',
            '#99ffff',
            '#9966ff',
            '#66ff99',
            '#66ff66',
            '#99ffcc',
            '#66cc66'
            );

        $borderColor = array(
            '#3300ff',
            '#336699',
            '#333399',
            '#3366ff',
            '#336666',
            '#006666',
            '#336666'
            );

        $day = date("d");
        $index = $day % 7 ;

        $this->assign('centerColor', $centerColor[$index]);//每日背景色替换
        $this->assign('borderColor', $borderColor[$index]);
    }

}

?>
