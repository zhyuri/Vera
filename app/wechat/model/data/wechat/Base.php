<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Base.php
*    description:     微信平台公用功能封装
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*
*/
class Data_Wechat_Base
{
    public $accessToken;

    function __construct()
    {
        $conf = Vera_Conf::getConf('global');
        $conf = $conf['testWechat'];
        $this->accessToken = $this->getAccessToken($conf['AppID'], $conf['AppSecret']);
    }

    public static function getAccessToken($appId, $appSecret)
    {
        if (!empty($this->accessToken)) {
            return $this->accessToken;
        }

        $api = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
        $url = sprintf($api, $appId, $appSecret);
        $handle = curl_init();
        $options = array(
                    CURLOPT_URL            => $url,
                    CURLOPT_HEADER         => 0,
                    CURLOPT_RETURNTRANSFER => 1
                    );
        curl_setopt_array($handle, $options);

        $content = curl_exec($handle);
        if (curl_errno($handle))//检查是否有误
            return false;
        curl_close($handle);

        $content = json_decode($content,true);
        return $content['access_token'];
    }

    public function getUserInfo($openID)
    {
        $accessToken = $this->accessToken;

        $api = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN";
        $url = sprintf($api, $accessToken, $openID);
        $handle = curl_init();
        $options = array(
                    CURLOPT_URL            => $url,
                    CURLOPT_HEADER         => 0,
                    CURLOPT_RETURNTRANSFER => 1
                    );
        curl_setopt_array($handle, $options);

        $content = curl_exec($handle);//执行
        if (curl_errno($handle))//检查是否有误
            return false;
        curl_close($handle);

        return json_decode($content,true);
    }
}

?>
