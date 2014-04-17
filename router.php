<?php

/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    filename:       router.php
*    description:    路由文件，找到对应的子程序，并协助设置好相关变量
*
*    @author Yuri
*    @license Apache v2 License
*    
**/

//当类初始化时，自动引入相关文件
function __autoload($className) 
{
    //解析文件名，得到文件的存放路径，如News_Model表示存放在model文件夹里的news.php（这里是作者的命名约定）  
    list($filename , $suffix) = explode('_' , $className);  

    //构成文件路径
    $file = SERVER_ROOT .'/'. strtolower($suffix) .'/'. strtolower($filename) . '.php';

    //获取文件
    if (file_exists($file))
    {
        //引入文件
        include_once($file);
    }
    else
    {  
        $file = SERVER_ROOT .'/plugin/'. strtolower($filename) . '.php';

        if(file_exists($file))
        {
            include_once($file);
        }
        else
        {
            //文件不存在  
            die("Hey man, what's up!"); 
        }     
    }
}


$controller = SERVER_ROOT . '/controller/main.php';

if (file_exists($controller))
{
    include_once($controller);

    $class = 'Main';

    //初始化对应的类
    if (class_exists($class))
    {
        $controllerClass = new $class;
    }
    else
    {
        //类的命名正确吗？
        die('找不到类');
    }
}
else
{
    die('找不到文件');
}

//将View包含进来
include_once(SERVER_ROOT . '/view/view.php');

$controllerClass->main($POSTobj);

?>