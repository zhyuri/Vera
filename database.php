<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		database.php
*	description:	这个Model专门负责数据库的连接和查询处理
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

class Database
{
	public $con;
	private $query;
	
    /** 
     * 构造函数，负责连接数据库
     * 
     */
	function __construct()
	{
		$host = VERA_HOST;
		$user = VERA_USER;
		$password = VERA_PASSWORD;
		$db = VERA_DB;

		$con = mysql_connect($host,$user,$password);
		if (!$con)
  		{
  			die('Could not connect: ' . mysql_error());
  		}
		mysql_select_db($db, $con);
		mysql_query("SET NAMES utf8");
  		$this->con = $con;

	}

    /** 
     * 安全检查
     * 
     * @param mix $input 输入数据
     *
     * @return mix $input 返回安全处理过的数据
     */
	private function checkInput($input)
	{
		$input = mysql_real_escape_string($input);

		return $input;
	}

    /** 
     * SQL查询函数，内置超时重连，缓存SQL查询并不立即执行
     *
     * @param string $query 输入的SQL语句
     *
     * @return bool 返回执行结果 
     */
	public function query($query)
	{
		//$query = $this->checkInput($query);
		$this->ping();
		$this->query = mysql_unbuffered_query($query);

		if($this->query == FALSE)
		{
			return FALSE;
		}
		return TRUE;
	}

    /** 
     * 与$this->query()搭配使用的函数，返回上一条执行结果的关联数组。
     *
     *	@return array $row 返回关联数组，如果出错返回FALSE 
     */
	public function getRow ()
	{
		$row = mysql_fetch_array($this->query,MYSQL_ASSOC);
		
		if ($row)
		//MYSQL_ASSOC参数决定了返回关联数组
			return $row;
		else
			return FALSE; 
	}

	 /** 
     * ping函数，负责检查数据库连接，如果断掉了，则关闭后重新连接
     * 
     */
	private function ping()
	{
    	if(!mysql_ping($this->con))
    	{
	        mysql_close(); //注意：一定要先执行数据库关闭，这是关键
	        $this->__construct();
    	}
	}

	/** 
     * 析构函数，关闭数据库连接
     *
     */  
    public function __destruct()  
    {
        mysql_close($this->con);
    }
}

?>