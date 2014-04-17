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

class View
{
    /** 
     * 保存视图渲染状态 
     */
    private $body = FALSE;

    /** 
     * 加载一个视图模板 
     */
    public function __construct($template = 'text')
    {

        //构成完整文件路径
        $file = SERVER_ROOT . '/view/' . $template . '.php';
        
        if (file_exists($file))
        {
            /**
             * 当模型对象销毁时才能渲染视图
             * 如果现在就渲染视图，那么我们就不能给视图模板赋予变量
             * 所以此处先保存要渲染的视图文件路径
             */
            $this->body = $file;
        }
    }

    /** 
     * 接受从控制器赋予的变量，并保存在data数组中 
     *
     * @param $variable 关联数组元素名
     * @param $value    对应的值
     */  
    public function assign($variable , $value)
    {  
        $this->data[$variable] = $value;
    }  

    /** 
     * 析构函数，把类中的data数组变为该函数的局部变量，以方便在视图模板中使用
     */  
    public function __destruct()  
    {
        $data = $this->data;
      
        //渲染视图
        include($this->body);

        //向微信服务器回复信息
        echo $view;
    }  
}  
?>