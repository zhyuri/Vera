<?php
/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	file:			index.php
*	description:	Vera 入口
*
*	@author Yuri
*	@license Apache v2 License
*
**/
header("Content-type: text/html; charset=utf-8");
include('tools/Bootstrap.php');

$class = new Vera_Bootstrap();
$class->init()->run();

?>
