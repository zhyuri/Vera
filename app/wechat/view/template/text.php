<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		text.php
*	description:	文本信息回复模板
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

$view = "<xml>
            <ToUserName><![CDATA[".$data['ToUserName']."]]></ToUserName>
            <FromUserName><![CDATA[".$data['FromUserName']."]]></FromUserName>
            <CreateTime>".$data['CreateTime']."</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[".$data['Content']."]]></Content>
        </xml>";


?>
