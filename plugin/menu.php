<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		menu.php
*	description:	二级菜单点击处理类
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
*	二级菜单点击处理类
*
**/
class Menu_Model
{
	private $EventKey;

	/**
    *	默认调用类
    *
    *	@param $json 返回值json编码
    *	@return 回复信息数组
    */
    public function handle($json = NULL)
    {
        //测试用，强制进入某二级菜单
        // $arr['model']='yiban';
        // $arr['func']='postList';
        // $arr['args']='';
        // return $this->specialReply($arr);
        
    	$answer = json_decode($json, true);
    	
    	foreach ($answer['menu'] as $each)
    	{
    		if($each['EventKey'] == $this->EventKey)//检查吻合的关键字
    		{
                //如果设置了回复模板则直接回复，若不是则调用特殊回复函数
                //特殊回复用的reply字段举例如下:
                /*{
                    "model":"xmu_jwc",//model名称
                    "func":"linkIn",//调用的函数名称
                    "args":""//参数数组
                }
                */
    			if(isset($each['reply']['template']))
    				$return = $each['reply'];
    			else
    				return $this->specialReply($each['reply']);
    			return $return;
    		}
    	}
    	return NULL;
    }

    /**
    *	设置被点击的菜单对应的Key值
    *
    *	@param key
    *	@return 无
    */
    public function setKey($EventKey)
    {
        echo $EventKey;
    	$this->EventKey = $EventKey;
    	return ;
    }

    /**
    *	特殊功能的回复函数
    *
    *	@param Array 特殊功能的相关信息()
    *	@return 回复数组
    */
    public function specialReply($specialFun)
    {
    	$class = $specialFun['model'] . "_Model";
        
        if(class_exists($class))
        {
            $model = new $class();
            if($return = $model->$specialFun['func']($specialFun['args']))
            {
                return $return;
            }
        }
        return $this->errReply();
    }

    /**
    *	默认回复的错误信息
    *
    *	@param 无
    *	@return 返回信息数组
    */
    private function errReply()
    {
    	$return['template'] = 'text';
    	$return['Content'] = "很抱歉功能出了问题，我们会尽快修复的！";
    	return $return;
    }

}

?>