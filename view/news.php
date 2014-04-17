<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		news.php
*	description:	图文信息回复模板
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

$head = "<xml>
            <ToUserName><![CDATA[".$data['ToUserName']."]]></ToUserName>
            <FromUserName><![CDATA[".$data['FromUserName']."]]></FromUserName>
            <CreateTime>".$data['CreateTime']."</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
			<ArticleCount>".count($data['Articles'])."</ArticleCount>
			";

$each = "<Articles>";
foreach ($data['Articles'] as $article)//多条图文消息信息，默认第一个item为大图,注意，如果图文数超过10，则将会无响应
{
	$each.= "<item>
				<Title><![CDATA[".$article['Title']."]]></Title> 
				<Description><![CDATA[".$article['Description']."]]></Description>
				<PicUrl><![CDATA[".$article['PicUrl']."]]></PicUrl>
				<Url><![CDATA[".$article['Url']."]]></Url>
			</item>";
}
$each.="</Articles>";

$view = $head . $each . "</xml>";

?>