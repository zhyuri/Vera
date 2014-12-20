<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Auth.php
*    description:     权威性验证库
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  权威性验证
*/
class Library_Auth
{
    function __construct() {}

    public static function generateToken($username, $password)
    {
        return md5($username.$password);
    }
}
?>
