<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Database.php
*	description:	数据库连接类
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
* 数据库连接与基本操作
*/
class Vera_Database
{
	private static $instance = NULL;
	private $mysql = NULL;
	private $isConnected;

	const LIST_COM = 0;
    const LIST_AND = 1;
    const LIST_SET = 2;

    // query result types
    const FETCH_RAW = 0;    // return raw mysqli_result
    const FETCH_ROW = 1;    // return numeric array
    const FETCH_ASSOC = 2;  // return associate array

	private function __construct()
	{
		$this->mysql = mysqli_init();

		$conf = Vera_Conf::getConf('database');
		$this->_connect($conf);

		$this->mysql->set_charset('utf8');
	}

	public static function getInstance()
	{
        if (self::$instance === NULL) {
            self::$instance = new Vera_Database();
        }
        return self::$instance;
	}

	/**
	* @brief 查询接口
	*
	* @param $sql 查询sql
	* @param $fetchType 结果集抽取类型
	* @param $bolUseResult 是否使用MYSQLI_USE_RESULT
	*
	* @return 结果数组：成功；false：失败
	*/
    public function query($sql, $fetchType = Vera_Database::FETCH_ASSOC, $bolUseResult = false)
    {
        if(!is_string($sql))
        {
        	Vera_Log::addWarning("Input SQL is not valid: '". $sql ."'");
            return false;
        }

        $res = $this->mysql->query($sql, $bolUseResult ? MYSQLI_USE_RESULT : MYSQLI_STORE_RESULT);

        $ret = false;

        // res is NULL if mysql is disconnected
        if(is_bool($res) || $res === NULL)
        {
            $ret = ($res == true);
            if(!$ret)
            {
                Vera_Log::addWarning("MySQL query failed: '". $sql ."'");
            }
        }
        // we have result
        else
        {
            switch($fetchType)
            {
                case Vera_Database::FETCH_ASSOC:
                    $ret = array();
                    while($row = $res->fetch_assoc())
                    {
                        $ret[] = $row;
                    }
                    $res->free();
                    break;

                case Vera_Database::FETCH_ROW:
                    $ret = array();
                    while($row = $res->fetch_row())
                    {
                        $ret[] = $row;
                    }
                    $res->free();
                    break;

                default:
                    $ret = $res;
                    break;
            }
        }

        return $ret;
    }

	/**
	* @brief select接口
	*
	* @param $tables 表名
	* @param $fields 字段名
	* @param $conds 条件
	* @param $options 选项
	* @param $appends 结尾操作
	* @param $fetchType 获取类型
	* @param $bolUseResult 是否使用MYSQL_USE_RESULT
	*
	* @return
	*/
    public function select(
        $tables, $fields, $conds = NULL, $options = NULL, $appends = NULL,
        $fetchType = self::FETCH_ASSOC, $bolUseResult = false
    )
    {
        $sql = $this->_getSelect($tables, $fields, $conds, $options, $appends);
        if(!$sql)
        {
            return false;
        }
        return $this->query($sql, $fetchType, $bolUseResult);
    }

    /**
	* @brief select count(*)接口
	*
	* @param $tables 表名
	* @param $conds 条件
	* @param $options 选项
	* @param $appends 结尾操作
	*
	* @return
	*/
    public function selectCount($tables, $conds = NULL, $options = NULL, $appends = NULL)
    {
        $fields = 'COUNT(*)';
        $sql = $this->_getSelect($tables, $fields, $conds, $options, $appends);
        if(!$sql)
        {
            return false;
        }
        $res = $this->query($sql, self::FETCH_ROW);
        if($res === false)
        {
            return false;
        }
        return intval($res[0][0]);
    }


	/**
	* @brief Insert接口
	*
	* @param $table 表名
	* @param $row 字段
	* @param $options 选项
	* @param $onDup 键冲突时的字段值列表
	*
	* @return
	*/
    public function insert($table, $row, $options = NULL, $onDup = NULL)
    {
        $sql = $this->_getInsert($table, $row, $options, $onDup);
        if(!$sql || !$this->query($sql))
        {
            return false;
        }
        return $this->mysql->affected_rows;
    }

	/**
	* @brief Update接口
	*
	* @param $table 表名
	* @param $row 字段
	* @param $conds 条件
	* @param $options 选项
	* @param $appends 结尾操作
	*
	* @return
	*/
    public function update($table, $row, $conds = NULL, $options = NULL, $appends = NULL)
    {
        $sql = $this->_getUpdate($table, $row, $conds, $options, $appends);
        if(!$sql || !$this->query($sql))
        {
            return false;
        }
        return $this->mysql->affected_rows;
    }

	/**
	* @brief delete接口
	*
	* @param $table 表名
	* @param $conds 条件
	* @param $options 选项
	* @param $appends 结尾操作
	*
	* @return
	*/
    public function delete($table, $conds = NULL, $options = NULL, $appends = NULL)
    {
        $sql = $this->_getDelete($table, $conds, $options, $appends);
        if(!$sql || !$this->query($sql))
        {
            return false;
        }
        return $this->mysql->affected_rows;
    }

  	/**
	* @brief 基于当前连接的字符集escape字符串
	*
	* @param $string 输入字符串
	*
	* @return
	*/
    public function escapeString($string)
    {
        return $this->mysql->real_escape_string($string);
    }

	private function _connect($conf = NULL)
	{
		if($conf == NULL)
			return false;

		$this->isConnected = $this->mysql->real_connect($conf['host'],$conf['username'],$conf['password'],$conf['dbname'],$conf['port']);
		if (!$this->isConnected)
		{
			Vera_Log::addErr('connect to MySQL failed');
			exit();
		}
		return $this->isConnected;
	}

	/**
	* @brief 获取select语句
	*
	* @param $tables 表名
	* @param $fields 字段名
	* @param $conds 条件
	* @param $options 选项
	* @param $appends 结尾操作
	*
	* @return
	*/
	private function _getSelect($tables, $fields, $conds = NULL, $options = NULL, $appends = NULL)
	{
	    $sql = 'SELECT ';

	    // 1. options
	    if($options !== NULL)
	    {
	        $options = $this->_makeList($options, Vera_Database::LIST_COM, ' ');
	        if(!strlen($options))
	        {
	            $this->sql = NULL;
	            return NULL;
	        }
	        $sql .= "$options ";
	    }

	    // 2. fields
	    $fields = $this->_makeList($fields, Vera_Database::LIST_COM);
	    if(!strlen($fields))
	    {
	        $this->sql = NULL;
	        return NULL;
	    }
	    $sql .= "$fields FROM ";

	    // 3. from
	    $tables = $this->_makeList($tables, Vera_Database::LIST_COM);
	    if(!strlen($tables))
	    {
	        $this->sql = NULL;
	        return NULL;
	    }
	    $sql .= $tables;

	    // 4. conditions
	    if($conds !== NULL)
	    {
	        $conds = $this->_makeList($conds, Vera_Database::LIST_AND);
	        if(!strlen($conds))
	        {
	            $this->sql = NULL;
	            return NULL;
	        }
	        $sql .= " WHERE $conds";
	    }

	    // 5. other append
	    if($appends !== NULL)
	    {
	        $appends = $this->_makeList($appends, Vera_Database::LIST_COM, ' ');
	        if(!strlen($appends))
	        {
	            $this->sql = NULL;
	            return NULL;
	        }
	        $sql .= " $appends";
	    }

	    $this->sql = $sql;
	    return $sql;
	}

    /**
    * @brief 获取insert语句
    *
    * @param $table 表名
    * @param $row 字段
    * @param $options 选项
    * @param $onDup 键冲突时的字段值列表
    *
    * @return
    */
    private function _getInsert($table, $row, $options = NULL, $onDup = NULL)
    {
        $sql = 'INSERT ';

        // 1. options
        if($options !== NULL)
        {
            if(is_array($options))
            {
                $options = implode(' ', $options);
            }
            $sql .= "$options ";
        }

        // 2. table
        $sql .= "$table SET ";

        // 3. clumns and values
        $row = $this->_makeList($row, Vera_Database::LIST_SET);
        if(!strlen($row))
        {
            $this->sql = NULL;
            return NULL;
        }
        $sql .= $row;

        if(!empty($onDup))
        {
            $sql .= ' ON DUPLICATE KEY UPDATE ';
            $onDup = $this->_makeList($onDup, Vera_Database::LIST_SET);
            if(!strlen($onDup))
            {
                $this->sql = NULL;
                return NULL;
            }
            $sql .= $onDup;
        }
        $this->sql = $sql;
        return $sql;
    }

    /**
    * @brief 获取update语句
    *
    * @param $table 表名
    * @param $row 字段
    * @param $conds 条件
    * @param $options 选项
    * @param $appends 结尾操作
    *
    * @return
    */
    private function _getUpdate($table, $row, $conds = NULL, $options = NULL, $appends = NULL)
    {
        if(empty($row))
        {
            return NULL;
        }
        return $this->_makeUpdateOrDelete($table, $row, $conds, $options, $appends);
    }

    /**
    * @brief 获取delete语句
    *
    * @param $table
    * @param $conds
    * @param $options
    * @param $appends
    *
    * @return
    */
    private function _getDelete($table, $conds = NULL, $options = NULL, $appends = NULL)
    {
        return $this->_makeUpdateOrDelete($table, NULL, $conds, $options, $appends);
    }

    private function _makeUpdateOrDelete($table, $row, $conds, $options, $appends)
    {
        // 1. options
        if($options !== NULL)
        {
            if(is_array($options))
            {
                $options = implode(' ', $options);
            }
            $sql = $options;
        }

        // 2. fields
        // delete
        if(empty($row))
        {
            $sql = "DELETE $options FROM $table ";
        }
        // update
        else
        {
            $sql = "UPDATE $options $table SET ";
            $row = $this->_makeList($row, Vera_Database::LIST_SET);
            if(!strlen($row))
            {
                $this->sql = NULL;
                return NULL;
            }
            $sql .= "$row ";
        }

        // 3. conditions
        if($conds !== NULL)
        {
            $conds = $this->_makeList($conds, Vera_Database::LIST_AND);
            if(!strlen($conds))
            {
                $this->sql = NULL;
                return NULL;
            }
            $sql .= "WHERE $conds ";
        }

        // 4. other append
        if($appends !== NULL)
        {
            $appends = $this->_makeList($appends, Vera_Database::LIST_COM, ' ');
            if(!strlen($appends))
            {
                $this->sql = NULL;
                return NULL;
            }
            $sql .= $appends;
        }

        $this->sql = $sql;
        return $sql;
    }

	private function _makeList($arrList, $type = Vera_Database::LIST_SET, $cut = ', ')
    {
        if(is_string($arrList))
        {
            return $arrList;
        }

        $sql = '';

        // for set in insert and update
        if($type == Vera_Database::LIST_SET)
        {
            foreach($arrList as $name => $value)
            {
                if(is_int($name))
                {
                    $sql .= "$value, ";
                }
                else
                {
                    if(!is_int($value))
                    {
                        if($value === NULL)
                        {
                            $value = 'NULL';
                        }
                        else
                        {
                            $value = '\''.$this->escapeString($value).'\'';
                        }
                    }
                    $sql .= "$name=$value, ";
                }
            }
            $sql = substr($sql, 0, strlen($sql) - 2);
        }
        // for where conds
        else if($type == Vera_Database::LIST_AND)
        {
            foreach($arrList as $name => $value)
            {
                if(is_int($name))
                {
                    $sql .= "($value) AND ";
                }
                else
                {
                    if(!is_int($value))
                    {
                        if($value === NULL)
                        {
                            $value = 'NULL';
                        }
                        else
                        {
                            $value = '\''.$this->escapeString($value).'\'';
                        }
                    }
                    $sql .= "($name=$value) AND ";
                }
            }
            $sql = substr($sql, 0, strlen($sql) - 5);
        }
        else
        {
            $sql = implode($cut, $arrList);
        }

        return $sql;
    }


}
?>
