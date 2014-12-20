<?php
/**
*
*   @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*   All rights reserved
*
*   file:           Linkin.php
*   description:    绑定页面
*
*   @author Yuri
*   @license Apache v2 License
*
**/

/**
*
*/
class Action_Linkin extends Action_Base
{

    function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function run()
    {
        $resource = $this->getResource();
        $openid = $resource['openid'];

        $view = new Vera_View(false);//设置为true开启debug模式
        $view->setCaching(Smarty::CACHING_OFF);//关闭缓存

        $model = new Service_Info($resource);
        //获取绑定状态
        $info = $model->linkinInfo();

        $view->assign('title','帐号绑定');
        $view->assign('openid', $resource['openid']);

        $view->assign('xmu',$info['xmu']);
        $view->assign('yiban',$info['yiban']);


        $view->dailyBackground();
        $view->display('wap/Linkin.tpl');
        return true;
    }
}

?>
