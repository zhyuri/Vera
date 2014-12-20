<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            XmuLinkin.php
*    description:     厦大绑定入口
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  厦大帐号绑定
*/
class  Action_Api_Xmulinkin extends Action_Base
{

    function __construct() {}

    public function run()
    {
        $resource = $this->getResource();
        $num = $resource['num'];
        $password = $resource['password'];
        $service = new Service_Xmu_Aa($resource);

        $ret = array('errno' => '0', 'errmsg' => 'OK');
        if (!$service->linkIn($num, $password)) {
            $ret = array('errno' => '3001', 'errmsg' => '用户名或密码错误');
        }

        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        return true;
    }
}

?>
