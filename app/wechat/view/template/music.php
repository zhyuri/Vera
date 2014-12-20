<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		music.php
*	description:	音乐信息回复模板
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

$view = "<xml>
            <ToUserName><![CDATA[".$data['ToUserName']."]]></ToUserName>
            <FromUserName><![CDATA[".$data['FromUserName']."]]></FromUserName>
            <CreateTime>".$data['CreateTime']."</CreateTime>
            <MsgType><![CDATA[music]]></MsgType>
			<Music>
				<Title><![CDATA[".$data['Title']."]]></Title>
				<Description><![CDATA[".$data['Description']."]]></Description>
				<MusicUrl><![CDATA[".$data['MusicUrl']."]]></MusicUrl>
				<HQMusicUrl><![CDATA[".$data['HQMusicUrl']."]]></HQMusicUrl>
				<ThumbMediaId><![CDATA[".$data['ThumbMediaId']."]]></ThumbMediaId>
			</Music>
        </xml>";

?>