<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Login.php
*    description:     登录校验 api
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  登录校验
*/
class  Action_Api_Login extends Action_Base
{

    function __construct()
    {

    }

    public function run()
    {
        if (isset($_GET['m']) && $_GET['m'] == 'logout') {
            return $this->_logout();
        }
        else {
            return $this->_login();
        }
    }

    private function _login()
    {

        if (!isset($_POST['user']) || !isset($_POST['pwd'])) {
            $ret = array('error'=>'1','errmsg'=>'参数错误');
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
            return false;
        }
        $ret = array('error'=>'0','errmsg'=>'OK');
        $username = htmlspecialchars($_POST['user']);
        $password = htmlspecialchars($_POST['pwd']);

        $data = new Data_Admin();
        $info = $data->getInfo($username);

        if (!$info) {
            $ret = array('error'=>'-1','errmsg'=>'用户名或密码错误');
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
            return false;
        }

        $token = Library_Auth::generateToken($username, $password);

        if ($info['token'] != $token) {//密码校验失败
            unset($_SESSION);
            $ret = array('error'=>'-1','errmsg'=>'用户名或密码错误');
        }
        else {
            $_SESSION['id'] = $info['id'];//管理员 id
            $_SESSION['name'] = $info['nickname'];//昵称
            $_SESSION['level'] = $info['level'];//管理等级
        }

        echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        return true;
    }

    private function _logout()
    {
        session_destroy();
        header("Location: http://120.24.83.112");
        return true;
    }

}

?>
