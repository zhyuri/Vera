<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Event.php
*    description:    事件信息入口
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
* 事件信息处理入口
*/
class Action_Event extends Action_Base
{

    function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function run()
    {
        $resource = $this->getResource();

        switch ($resource['Event']) {
            case 'CLICK':
                $ret = $this->_click();
                break;
            case 'subscribe':
                $ret = $this->_subscribe();
                break;

            default:
                $conf = Vera_Conf::getAppConf('common');
                $ret = $conf['defaultReply'];
                break;
        }

        if (empty($ret)) {
            throw new Exception("很抱歉公众号出现异常", 1);
        }

        //寻找模板
        $view = new View_Wechat($resource);
        $view->assign($ret);
        $view->display();

        return true;

    }

    private function _click()
    {
        $resource = $this->getResource();
        Vera_Log::addNotice('eventKey', $resource['EventKey']);
        Vera_Log::addNotice('event', $resource['Event']);

        $conf = Vera_Conf::getAppConf('common');
        $result = Data_Wechat_Db::eventReply($resource['EventKey']);

        if (!$result) {
            //出错回复
            $ret = $conf['errMsg'];
        }
        elseif (in_array($result['replyType'], $conf['replyType'])) {
            //固定回复
            $ret['type'] = $result['replyType'];
            $ret['data'] = json_decode($result['reply'], true);
        }
        else {
            //功能性回复
            $class = 'Service_' . $result['replyType'];
            $instance = new $class($resource);
            $ret = $instance->{$result['reply']}();
        }

        return $ret;
    }

    private function _subscribe()
    {
        $resource = $this->getResource();
        Vera_Log::addNotice('event', $resource['Event']);

        $conf = Vera_Conf::getAppConf('common');
        return $conf['subscribe'];//回复欢迎信息
    }
}

?>
