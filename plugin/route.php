<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		route.php
*	description:	路径规划类，接收关键字返回乘车信息
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

include_once("BaiduMapAPI.php");//包含入父类
/**
*	路径规划类（未完成）
*
**/
class Route_Model extends BaiduMapAPI
{
    private $latitude = 0;
    private $longitude = 0;
    private $precision = 0;

	function __construct()
	{
		parent::__construct();
	}

	/**
	*	默认调用函数
	*
	*	@param $key 关键字
	*	@return 返回回复信息数组
	*/
	public function handle($key='driving')
	{
		if($this->latitude == 0)//如果没有设置参数的话，无法定位
			return NULL;

        $start['latitude'] = $this->latitude;
        $start['longitude'] = $this->longitude;

        $end = $this->getLocation();

        $result = $this->getRoute($start,$end,$key);//获得api返回数组
        return $this->view($result);//格式化后返回
	}

	/**
	*	设置相关参数（用户的）
	*
	*	@param  $latitude 纬度
	*			$longitude 经度
	*			$precision 精度
	*
	*	@return NULL 无需返回
	*/
	public function setParam($latitude = 0,$longitude = 0,$precision = 0)
	{
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->precision = $precision;

	}

	/**
	*	将结果格式化
	*
	*	@param getRoute函数返回结果
	*	@return array 可供显示的数组
	*/
	private function view($result)
	{
        $return['template'] = 'text';

        $content = "驾车路线:\n";
        // $content.= "起点:".$result['origin']['cname']."\n";
        // $content.= "终点:".$result['destination']['cname']."\n";

        	$distance = (float)$result['routes'][0]['distance'] / 1000.0;//换算成公里
        $content.= "总距离:".$distance."公里\n";

        	$cost = $this->timeFormat($result['routes'][0]['duration']);//格式化秒数
        $content.= "用时约:".$cost."\n";

        $content.= "详细导航如下:\n";
        foreach ($result['routes'][0]['steps'] as $step)
        {
        	$content.= strip_tags($step['instructions'])."\n";//去除html标签
        }

        $content.="\n出租车信息:\n";
        // $content.="起终点之间距离". (float)$result['taxi']['distance'] / 1000.0 ."公里\n";
        // 	$cost = $this->timeFormat($result['taxi']['duration']);
        // $content.="耗时约:".$cost."\n";
        
        foreach ($result['taxi']['detail'] as $each)
        {
        	$content.= $each['desc']."时段总价约:".$each['total_price']."元\n";
        }

        $content.="备注:".$result['taxi']['remark'];

        $return['Content'] = $content;

        return $return;
	}

	/**
	*	格式化时间
	*
	*	@param $time 秒数
	*	@return string 天时分秒
	*/
	private function timeFormat($time)
	{
		$output = '';

  		foreach (array(86400 => '天', 3600 => '小时', 60 => '分', 1 => '秒') as $key => $value)
  		{
			if ($time >= $key)
				$output .= floor($time/$key) . $value;
			$time %= $key;
		}
  		return $output;
	}

}

?>