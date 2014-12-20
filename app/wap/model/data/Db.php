<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Db.php
*    description:     数据库交互 Data 类
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*  数据库交互
*/
class  Data_Db extends Data_Base
{

    function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * 获取当前用户的绑定情况
     * @return  array  绑定情况
     */
    public function getLinkinInfo()
    {
        $ret = array('xmu'=>'0','yiban'=>'0');
        if ($this->isLink()) {
            $ret['xmu'] = '1';
        }
        $time = $this->getYibanExpireTime();
        if ($time && $time > date("Y-m-d H:i:s")) {
            $ret['yiban'] = '1';
        }
        return $ret;
    }

    /**
     * 更新数据库中厦大绑定信息
     * @param   string $num       学号
     * @param   string $password  密码
     * @return  bool
     */
    public function updateXmu($num, $password)
    {
        $set = array(
                'xmu_num' => $num,
                'xmu_password' => $password,
                'xmu_isLinked' => 1,
                'xmu_linkTime' => date("Y-m-d H:i:s")
            );
        $db = Vera_Database::getInstance();
        if ($this->isLink() !== NULL) {//已绑定过,update
            $id = $this->getID();
            $db->update('vera_User', $set, array('id' => $id));
        }
        else {//未绑定,插入新行
            $resource = $this->getResource();
            $set['wechat_id'] = $resource['openid'];
            $db->insert('vera_User', $set);
        }
        return true;
    }

    /**
     * 更新数据库中厦大绑定信息
     * @param   string $num       学号
     * @param   string $password  密码
     * @return  bool
     */
    public function unLinkXmu()
    {
        if ($this->isLink()) {//已绑定过
            $db = Vera_Database::getInstance();
            $id = $this->getID();
            $set = array(
                'xmu_isLinked' => 0
            );
            $db->update('vera_User', $set, array('id' => $id));
        }
        return true;
    }

    /**
    *   登录验证获取登录cookie
    *
    *   @param int 学号
    *   @param string 密码
    *   @return bool 成功时返回true，失败时false
    */
    public function xmuCheck($num, $password)
    {
        $post_data = "Login.Token1=".$num;
        $post_data.= "&Login.Token2=".$password;

        $handle = curl_init();

        $options = array(
                    CURLOPT_URL            => 'http://idstar.xmu.edu.cn/amserver/UI/Login',
                    CURLOPT_HEADER         => 0,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_COOKIEJAR      => "",
                    CURLOPT_POST           => 1,
                    CURLOPT_POSTFIELDS     => $post_data
                    );
        curl_setopt_array($handle, $options);

        curl_exec($handle);//执行

        if(curl_getinfo($handle,CURLINFO_HTTP_CODE) == 302)//302说明验证成功
            return true;

        return false;
    }
}

?>
