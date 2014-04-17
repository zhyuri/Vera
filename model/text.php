<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		text.php
*	description:	文本信息处理Model
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

include_once("BossModel.php");//包含入父类
/**
*	这个类用于处理文本信息的响应
*
**/
class Text_Model extends Boss_Model
{

	function __construct()
	{
        parent::__construct();
	}

	/**
    *    文本信息处理函数
    *
    *    @param $xml 获取到的解析后的xml对象
    *    @return $return 返回所有信息的数组，必须包括$return['template']
    */
    public function handle($xml)
    {
        $text = $xml->Content;
        
        if($type = $this->isSpecial($text))//需要参数的特殊处理函数(比如注册/注销会员)
        {
            if($result = $this->specialReply($type,$text))//调用父类的特殊处理函数寻找对应的处理类
                return $result;
            else
                return $this->defaultReply();
        }

        $sql = "select * from Keyword where keyword = '{$text}' and serverID = '{$this->ServerName}'";
        
        return $this->usualReply($sql);
    }


    /**
    *   检查是否有特殊关键字
    *
    *   @param $input 输入字符串
    *   @return bool
    */
    private function isSpecial($input)
    {
        $input = mb_substr($input, 0, 2, "UTF-8");//截取前两个字作为特殊关键字进行判断

        $sql = "select * from SpecialWords where serverID = '{$this->ServerName}' and specialWords = '{$input}'";
        
        if($this->db->query($sql))
        {
            $result = $this->db->getRow();
            return $result['plugin'];
        }
        else
        {
            return FALSE;
        }
    }

}

?>