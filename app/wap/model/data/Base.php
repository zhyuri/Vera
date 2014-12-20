<?php
/**
*
*   @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*   All rights reserved
*
*   file:           base.php
*   description:    Data基类
*
*   @author Yuri
*   @license Apache v2 License
*
**/

/**
* Model基类，负责通用的用户信息获取
* 如果其他app调用此data层，构造函数只需要$resource['ID']也就是用户ID。
*/
class Data_Base
{
    private static $resource = NULL;
    private static $userInfo = NULL;

    function __construct($resource)
    {
        self::$resource = $resource;
    }

    protected function getResource()
    {
        return self::$resource;
    }

    protected function setResource($_resource)
    {
        if(empty($_resource))
            throw new Exception("Resource can not be empty", 1);

        self::$resource = $_resource;
    }

    protected static function getUserInfo()
    {
        if (empty(self::$resource))
            throw new Exception("Resource can not be empty", 1);

        if(!$db = Vera_Database::getInstance())
            throw new Exception("Cannot get instance of database", 1);

        $result = $db->select('vera_User', '*', array('wechat_id' => self::$resource['openid']));

        if (!$result) {
            self::$userInfo = -1;
            return NULL;
        }
        self::$userInfo = $result[0];
        return $result[0];
    }

    private function _getInfo($info)
    {
        if (self::$userInfo == -1) {
            return NULL;
        }
        $ret = empty(self::$userInfo) ? self::getUserInfo() : self::$userInfo;
        return $ret[$info];

    }

    protected function getID()
    {
        return $this->_getInfo('id');
    }

    protected function getStuNum()
    {
        return $this->_getInfo('xmu_num');
    }

    protected function getStuPass()
    {
        return $this->_getInfo('xmu_password');
    }

    protected function isLink()
    {
        return $this->_getInfo('xmu_isLinked');
    }

    protected function getYibanUid()
    {
        return $this->_getInfo('yiban_uid');
    }

    protected function getYibanAccess()
    {
        return $this->_getInfo('yiban_accessToken');
    }

    protected function getYibanRefresh()
    {
        return $this->_getInfo('yiban_refreshToken');
    }

    protected function getYibanExpireTime()
    {
        return $this->_getInfo('yiban_expireTime');
    }

}
?>
