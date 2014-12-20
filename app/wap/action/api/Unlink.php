<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Unlink.php
*    description:     解绑 api
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  解除绑定
*/
class  Action_Api_Unlink extends Action_Base
{

    function __construct() {}

    public function run()
    {
        $resource = $this->getResource();
        $service = new Service_Xmu_Aa($resource);

        $service->unLink();

        $ret = array('errno' => '0', 'errmsg' => 'OK');
        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        return true;
    }
}

?>
