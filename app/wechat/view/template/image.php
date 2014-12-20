<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		image.php
*	description:	图片信息回复模板
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

$view = "<xml>
            <ToUserName><![CDATA[".$data['ToUserName']."]]></ToUserName>
            <FromUserName><![CDATA[".$data['FromUserName']."]]></FromUserName>
            <CreateTime>".$data['CreateTime']."</CreateTime>
			<MsgType><![CDATA[image]]></MsgType>
			<Image>
				<MediaId><![CDATA[".$data['MediaId']."]></MediaId>
			</Image>
		</xml>";

?>