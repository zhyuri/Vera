<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Db.php
*    description:    微信数据库读写操作
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*
*/
class Data_Wechat_Db extends Data_Base
{

    function __construct($resource)
    {
        parent::__construct($resource);
    }

    public static function keywordReply($keyword)
    {
        $db = Vera_Database::getInstance();
        $result = $db->select('wechat_Keyword', '*', array('keyword' => $keyword));
        if (!$result) {
            return false;
        }
        return $result[0];
    }

    public static function eventReply($key)
    {
        $db = Vera_Database::getInstance();
        $result = $db->select('wechat_Click', '*', array('event_key' => $key));
        if (!$result) {
            return false;
        }
        return $result[0];
    }
}

?>
