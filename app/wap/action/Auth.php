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

	function __construct() {}

	public static function run()
	{
		switch (ACTION_NAME) {
            case 'Linkin':
            case 'Api_Unlink':
                return self::_linkin();
                break;
            case 'Api_Xmulinkin':
                return self::_xmuLinkin();
                break;
            case 'Api_Yibanlinkin':
                return self::_yibanLinkin();
                break;
            default:
                return true;
                break;
        }
	}

    private static function _linkin()
    {
        if (!isset($_GET['openid'])) {
            return false;
        }
        $resource['openid'] = $_GET['openid'];
        parent::setResource($resource);
        return true;
    }

    private static function _xmuLinkin()
    {
        if (!isset($_POST['num']) || !isset($_POST['password']) || !isset($_POST['openid'])) {
            $ret = array('errno' => '3001', 'errmsg' => '参数错误');
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
            return false;
        }
        $resource['num'] = $_POST['num'];
        $resource['password'] = $_POST['password'];
        $resource['openid'] = $_POST['openid'];
        parent::setResource($resource);
        return true;
    }

    private static function _yibanLinkin()
    {
        return false;
    }

}
?>
