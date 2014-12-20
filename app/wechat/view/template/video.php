<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		video.php
*	description:	视频信息回复模板
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

$view = "<xml>
            <ToUserName><![CDATA[".$data['ToUserName']."]]></ToUserName>
            <FromUserName><![CDATA[".$data['FromUserName']."]]></FromUserName>
            <CreateTime>".$data['CreateTime']."</CreateTime>
            <MsgType><![CDATA[video]]></MsgType>
			<Video>
				<MediaId><![CDATA[".$data['MediaId']."]></MediaId>
			<Title><![CDATA[".$data['Title']."]]></Title>
				<Description><![CDATA[".$data['Description']."]]></Description>
			</Video>
        </xml>";

?>