<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Wechat.php
*    description:     微信相关数据表操作封装
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
*
*/
class Data_Wechat
{

    function __construct()
    {
        # code...
    }

    public function keywordList()
    {
        $db = Vera_Database::getInstance();
        $result = $db->select('wechat_Keyword', '*');
        if (!$result) {
            return false;
        }
        return $result;
    }

    public function setKeyword($word, $type, $reply, $id = '')
    {
        $db = Vera_Database::getInstance();
        $data = array('word'=>$word, 'replyType'=>$type, 'reply'=>$reply);

        if ($id == '') {//新增条目
            return $db->insert('wechat_Keyword', $data);
        }
        else {//修改现有条目
            $data['id'] = $id;
            return $db->update('wechat_Keyword', $data);
        }
    }

    public function clickList()
    {
        $db = Vera_Database::getInstance();
        $result = $db->select('wechat_Click', '*');
        if (!$result) {
            return false;
        }
        return $result;
    }
}

?>
