<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Aa.php
*    description:     厦大相关 wap 页面
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  厦大相关 wap
*/
class Service_Xmu_Aa
{
    private static $resource = NULL;

    function __construct($_resource = NULL)
    {
        self::$resource = $_resource;
    }

    /**
     * 绑定厦大帐号
     * @param    bool $num       学号
     * @param   string $password  密码
     * @return  bool            绑定情况
     */
    function linkIn($num, $password)
    {
        $data = new Data_Db(self::$resource);
        if($data->xmuCheck($num, $password)) {
            $data->updateXmu($num, $password);
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * 解除绑定厦大帐号
     * @return  bool            绑定情况
     */
    function unLink()
    {
        $data = new Data_Db(self::$resource);
        $data->unLinkXmu();
        return true;
    }
}
?>
