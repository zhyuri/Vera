<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Index.php
*    description:    CMS 控制面板主页
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
* CMS 控制面板
*/
class  Action_Board_Index extends Action_Base
{

    function __construct()
    {

    }

    public function run()
    {
        $view = new Vera_View(true);//设置为true开启debug模式

        $modelList = array(
            array('name'=>'用户管理','key'=>'user'),
            array('name'=>'文本消息','key'=>'text'),
            array('name'=>'事件消息','key'=>'event'),
            array('name'=>'自定义菜单','key'=>'menu'),
            array('name'=>'签到平台','key'=>'checkin'),
            array('name'=>'抢票平台','key'=>'ticket'),
            array('name'=>'推送平台','key'=>'push'),
            array('name'=>'平台管理','key'=>'admin')
            );
        $view->assign('models',$modelList);
        $view->display('cms/Board.tpl');
        return true;
    }
}

?>
