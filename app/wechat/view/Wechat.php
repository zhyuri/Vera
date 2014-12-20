<?php

/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    filename:        view.php
*    description:    处理选择模板返回内容
*
*    @author Yuri
*    @license Apache v2 License
*
**/

class View_Wechat
{
    private static $_isDisplay = FALSE;

    private static $_tpl = FALSE;

    private static $_data = NULL;

    /**
     * 构造函数
     */
    public function __construct($resource = NULL)
    {
        self::$_data['ToUserName'] = $resource['FromUserName'];
        self::$_data['FromUserName'] = $resource['ToUserName'];
        self::$_data['CreateTime'] = time();
    }

    /**
     * 设置模板
     * @param string $template 模板文件名
     */
    public function setTemplate($template = 'text')
    {
        //构成完整文件路径
        $file = SERVER_ROOT . 'app/wechat/view/template/' . $template . '.php';

        if (file_exists($file))
        {
            self::$_tpl = $file;
        }
        else
        {
            Vera_Log::addErr('cannot find template '.$file);
            exit();
        }
    }

    /**
     * 接收从actions层传入的数组
     * @param  array $ret 返回信息数组
     */
    public function assign($ret = '')
    {
        self::setTemplate($ret['type']);
        self::$_data = array_merge(self::$_data,$ret['data']);
    }

    /**
     * 显式的展现
     */
    public static function display()
    {
        $data = self::$_data;

        //渲染视图
        include(self::$_tpl);

        //向微信服务器回复信息
        echo $view;

        self::$_isDisplay = true;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        if (!self::$_isDisplay) {
            self::display();
        }
    }
}
?>
