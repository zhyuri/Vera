<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		blog.php
*	description:	个人博客信息获取类
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
*	获取个人博客的信息
*
**/
class Blog_Model
{
	private $url;

    function __construct()
    {
        $this->url = "http://blog.csdn.net/yuri_4_vera";
    }

    /**
    *	默认调用类
    *
    *	@param $key 关键字
    *	@return 回复信息数组
    */
    public function handle($key = NULL)
    {
    	if($get = $this->getInfo())
    	{
    		$return['template'] = 'news';

    		$return['Articles'] = array();
        	$return['Articles'][0]['Title'] = "Coder成长之路";//图文信息大标题

            $temp .=$get[0]."\n";//访问
            $temp .=$get[1]."\n";//积分
            $temp .=$get[2]."\n";//排名
            $temp .=$get[3]."      ";//原创
            $temp .=$get[4]."\n";//转载
            $temp .=$get[5]."      ";//译文
            $temp .=$get[6]."\n";//评论

            $return['Articles'][0]['Description'] = $temp;
        	$return['Articles'][0]['PicUrl'] = "http://yurilab.sinaapp.com/img/blog_cover.png";//大图链接
        	$return['Articles'][0]['Url'] = "http://blog.csdn.net/yuri_4_vera";

        	return $return;
    	}
    	else
    		return NULL;
    }

	/**
	*	博客信息获取函数
	*
	*	@param 无
	*	@return 返回博客信息数组
	*/
    public function getInfo()
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);

        if($content)
        {
            $regex = '/<li>(.*?)<\/li>/si';
            if(preg_match_all($regex, $content,$result,PREG_PATTERN_ORDER))
            {
                for ( $i = 0; $i < 7; $i ++ )
                {
                    $result[1][$i] = preg_replace("<[][^</span>]*>","", $result[1][$i]);
                }
                return $result[1];
            }
        }
        else
            return NULL;
        
    }
}

?>