<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		cet.php
*	description:	四六级查询类
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
*	四六级查询类
*
**/
class Cet_Model
{
	
	function __construct()
	{
		
	}

	/**
	*	默认调用函数
	*
	*	@param 参数
	*	@return 返回值
	*/
	public function handle($input)
	{
		mb_internal_encoding('UTF-8');
		$input = mb_substr($input, 2);
		$id = mb_substr($input, 0, 15);
		$name = mb_substr($input, 15, 6);

		return $this->getScoreByNoAndName($id,$name);
	}

	/**
	*	根据准考证号和姓名获取最新成绩
	*
	*	@param  $cetID 准考证号(15位)
	*			$cetName 姓名
	*	@return 返回信息数组
	*/
	public function getScoreByNoAndName($cetID,$cetName)
	{
		$ch = curl_init();
		$url = "http://www.chsi.com.cn/cet/query?zkzh={$cetID}&xm={$cetName}";
		curl_setopt($ch, CURLOPT_REFERER, "http://www.chsi.com.cn");
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);

        $match = "#<td[.\s\S]*?>[.\s\S]*?<\/td>#";

        preg_match_all($match, $content, $result);
        
        $name = strip_tags($result[0][2]);
        $school = strip_tags($result[0][3]);
        $cet = strip_tags($result[0][4]);
        $time = strip_tags($result[0][6]);

        $score = $result[0][7];
        $score = strip_tags($score);
        $score = str_replace("\t", "", $score);
        $score = str_replace(" ", "", $score);

        $arr = split("\n", $score);
        $total = $arr[3];
        $listen = $arr[9];
        $reading = $arr[13];
        $writingAndTranslate = $arr[18];

        $return['template'] = "text";
        
        $temp = "您好！来自{$school}的{$name}\n您{$time}的{$cet}\n";
        $temp.= "\n总成绩:{$total}\n";
        $temp.= "\n听力:{$listen}";
        $temp.= "\n阅读:{$reading}";
        $temp.= "\n写作与翻译:{$writingAndTranslate}";

        $return["Content"] = $temp;
        return $return;
	}
}

?>