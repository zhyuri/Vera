<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			text.php
*	description:	文本信息action
*
*	@author Yuri
*	@license Apache v2 License
*
**/

/**
* 文本信息处理入口
*/
class Action_Text extends Action_Base
{

	function __construct($resource)
	{
		parent::__construct($resource);
	}

	public function run()
	{
		$resource = $this->getResource();
		Vera_Log::addNotice('content', $resource['Content']);

		$conf = Vera_Conf::getAppConf('common');
		$reply = Data_Wechat_Db::keywordReply($resource['Content']);

		if (!$reply) {
			//默认回复
			$ret = $conf['defaultReply'];
		}
		elseif (in_array($reply['replyType'], $conf['replyType'])) {
			//固定回复
			$ret['type'] = $reply['replyType'];
			$ret['data'] = json_decode($reply['reply'], true);
		}
		else {
			//功能性回复
			$class = 'Service_' . $reply['replyType'];
			$instance = new $class($resource);
			$ret = $instance->{$reply['reply']}();
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
}

?>
