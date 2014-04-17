<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		BaiduMapAPI.php
*	description:	百度地图api父类，实现基础的api功能，便于相关插件直接使用
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
*	百度地图api父类
*
**/
class BaiduMapAPI
{
    private $ServerName;

    private $routeApi = "http://api.map.baidu.com/direction/v1?";//导航api
    private $searchApi = "http://api.map.baidu.com/place/v2/search?";//查询地点api
    private $geoApi = "http://api.map.baidu.com/geocoder/v2/?";//GeocodingAPI
    private $locationIP = "http://api.map.baidu.com/location/ip?";//根据ip获取位置信息
	
	function __construct()
	{
        $this->ServerName = $GLOBALS['ServerName'];
	}

	/**
	*	获取数据库中该公众号的经纬度
	*
	*	@param 无
	*	@return array 经度纬度数组
	*/
	protected function getLocation()
	{
		$db = new Database();

		$sql = "select * from ServerID where serverID = '{$this->ServerName}'";

		$db->query($sql);        
        $result = $db->getRow();

        $loc['latitude'] = $result['latitude'];
        $loc['longitude'] = $result['longitude'];

        return $loc;
	}

	/**
	*	为api添加AccessKey
	*
	*	@param $api api接口链接
	*	@return $api 加了ak的api链接
	*/
	private function addAk($api)
	{
		return $api."ak=" . BaiduAccessKey;
	}

	/**
	*	根据起始地点和行动方式获取导航信息，
	*
	*	@param  $start 起点
	*			$end   终点
	*			$mode  行动方式
	*	@return 返回值
	*/
	protected function getRoute($start,$end,$mode = 'dirving')
	{

		$query = $this->addAk($this->routeApi);
		$query.= "&origin=".$start['latitude'].",".$start['longitude'];
		$query.= "&destination=".$end['latitude'].",".$end['longitude'];
		$query.= "&mode=".$mode;
			$city = $this->getGeoInfo($start);
			$city = $city['addressComponent']['city'];
		$query.= "&region=".$city;
		$query.= "&origin_region=".$city;
			$city = $this->getGeoInfo($end);
			$city = $city['addressComponent']['city'];
		$query.= "&destination_region=".$city;
		$query.= "&output=json";
		$query.= "&tactics=11";
		$query.= "&coord_type=gcj02";//Google用的坐标体系

		$ch = curl_init($query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		$json = curl_exec($ch);//发送并接收回复
		curl_close($ch);

		$result = json_decode($json,true);//json解码返回关联数组
		if($result['status'] != 0)
			return NULL;//获取失败
		return $result['result'];

	}

	/**
	*	获得指定经纬度的相关信息（城市等）
	*
	*	@param $loc 经纬度数组
	*	@return array 相关信息
	*/
	protected function getGeoInfo($loc)
	{
		$query = $this->addAk($this->geoApi);
		$query.= "&location=".$loc['latitude'].",".$loc['longitude'];
		$query.= "&output=json&pois=0";

		$ch = curl_init($query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		$json = curl_exec($ch);//发送并接收回复
		curl_close($ch);

		$result = json_decode($json,true);//json解码返回关联数组
		if($result['status'] != 0)
			return NULL;//获取失败

		return $result['result'];

	}

	/**
	*	通过经纬度和半径以及关键词搜索相关内容
	*
	*	@param  $x 经度
	*		    $y 纬度
	*			$radius 半径
	*			$keyword 查询关键词
	*	@return 返回值
	*/
	protected function getInfoByGPS($x,$y,$radius,$keyword)
	{

		$query = $this->addAk($searchApi);
		$query.= "&query=". $keyword;//查询关键词
		$query.= "&location=".$x.",".$y ;//纬度，经度
		$query.= "&radius=". $radius;
		$query.= "&output=json";
		$query.= "&scope=2";//详细程度，设为2可以显示距离信息
		$query.= "&page_size=5";//返回5条记录，便于显示

		$ch = curl_init($query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		$json = curl_exec($ch);//发送并接收回复
		curl_close($ch);

		$result = json_decode($json,true);

		if($result['status'] != 0)
			return NULL;//获取失败

		return $result['result'];
	}

	/**
	*	通过ip获得位置信息 
	*
	*	@param $ip ip地址
	*	@return 返回值
	*/
	protected function getInfoByIP($ip)
	{

		$query = $this->addAk($locationIP);
		$query.= "&ip=".$ip;
		$query.= "&coor=bd09ll";

		$ch = curl_init($query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		$json = curl_exec($ch);//发送并接收回复
		curl_close($ch);

		$result = json_decode($json,true);

		if($result['status'] != 0)
			return NULL;//获取失败

		return $result['result'];
	}
}
?>