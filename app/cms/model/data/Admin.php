<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Admin.php
*    description:     管理员数据表操作封装
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  数据表操作
*/
class Data_Admin
{
    function __construct() {}

    public function getInfo($username)
    {
        $db = Vera_Database::getInstance();
        $cond = array('user'=>$username);
        $result = $db->select('cms_Admin', '*', $cond);
        if ($result) {
            return $result[0];
        }
        else {
            return false;
        }
    }
}

?>
