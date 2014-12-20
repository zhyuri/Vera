<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			Auth.php
*	description:	权威性验证action
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
* 权威性验证
*/
class Action_Auth extends Action_Base
{
    static $passList = array(
        'Api_Login',
        'Index'
        );

	function __construct() {}

	public static function run()
	{
        session_start();

        if (in_array(ACTION_NAME, self::$passList)) {//无条件通过
            return true;
        }

        if (!isset($_SESSION['level'])) {//若没有登录，则跳转至首页
            header("refresh:0;url=http://120.24.83.112/cms/index");
            return false;
        }

        //找出当前 Action 对应的 level
        $conf = Vera_Conf::getAppConf('authority');
        $level = 10;
        $actions = explode('_', ACTION_NAME);
        foreach ($actions as $action) {
            if (isset($conf[$action])) {
                if (is_array($conf[$action])) {
                    $conf = $conf[$action];
                }
                else {
                    $level = $conf[$action];
                }
            }
        }

        if ($_SESSION['level'] >= $level) {
            Vera_Log::addNotice('level',$_SESSION['level']);
            return true;
        }
        else {
            header("refresh:0;url=http://120.24.83.112/cms/index");
            return false;
        }

	}

}
?>
