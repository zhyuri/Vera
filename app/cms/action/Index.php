<?php
/**
*
*    @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*    All rights reserved
*
*    file:            Index.php
*    description:    CMS 主页
*
*    @author Yuri
*    @license Apache v2 License
*
**/

/**
* CMS 主页
*/
class Action_Index extends Action_Base
{

	function __construct($resource)
	{
		parent::__construct($resource);
	}

	public function run()
	{
        $view = new Vera_View(true);//设置为true开启debug模式

        $view->display('cms/Index.tpl');
        return true;
	}
}

?>
