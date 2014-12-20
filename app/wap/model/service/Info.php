<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Info.php
*    description:     基本信息获取 Service
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*
*/
class Service_Info
{
    private static $resource = NULL;

    function __construct($_resource = NULL)
    {
        self::$resource = $_resource;
    }

    public function linkinInfo()
    {
        $data = new Data_Db(self::$resource);
        $info = $data->getLinkinInfo();
        return $info;
    }
}

?>
