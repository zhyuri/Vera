<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Text.php
*    description:     文本关键词回复面板
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  文本信息配置面板
*/
class Action_Board_Panel_Text
{

    function __construct()
    {

    }

    public function run()
    {
        $view = new Vera_View(true);//设置为true开启debug模式
        $data = new Data_Wechat();
        $list = $data->keywordList();

        $view->assign('keywords', $list);
        $view->display('cms/panel/Text.tpl');
        return true;
    }
}

?>
