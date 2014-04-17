<?php

/**
*
*	@copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
*	All rights reserved
*
*	filename:		register.php
*	description:	会员注册处理函数
*
*	@author Yuri
*	@license Apache v2 License
*	
**/

/**
*	会员注册处理类
*
**/
class Register_Model
{
    public $db;

	public $ServerName;
    public $UserName;
	
	function __construct()
	{
		$this->ServerName = $GLOBALS['ServerName'];
        $this->UserName = $GLOBALS['UserName'];

        $this->db = new Database();
	}

    /**
    *	默认调用函数
    *
    *	@param $inputAll 输入的所有信息
    *	@return 回复信息数组
    */
    public function handle($inputAll)
    {
    	$return['template'] = 'text';
        mb_internal_encoding('UTF-8');
        $name = mb_substr($inputAll, 2);//截取需要的信息，即用户名

    	if(mb_strstr($inputAll,'注册'))
            $return['Content'] = $this->logInByName($name);

    	if($inputAll == '注销')
            $return['Content'] = $this->logOut();

        if($inputAll == '会员')
            $return = $this->memberInfo();
        
        return $return;
    }

    /**
    *	注册会员
    *
    *	@param $name 昵称
    *	@return 返回信息
    */
    private function logInByName($name)
    {
        if(empty($name))
            return '请输入昵称。';

        if($this->isLoged())
            return '很抱歉您已经注册过会员了';

    	$sql = "insert into Register_member (serverID,userID,name,inTime) values ('{$this->ServerName}','{$this->UserName}','{$name}','".date('Y-m-d H:i:s',time())."')";

        if($this->db->query($sql))
            return "欢迎您，会员{$name}。回复'会员'获取会员特权信息";
        else
            return "Sorry,似乎遇上了一些问题。";
    }

    /**
    *	注销会员
    *
    *	@param $name 昵称
    *	@return 返回信息 
    */
    public function logOut()
    {
        if(!$this->isLoged())
            return '很抱歉您还没有注册会员';

    	$sql = "delete from Register_member where serverID = '{$this->ServerName}' and userID = '{$this->UserName}'";

        if($this->db->query($sql))
            return "您好，您的会员身份已注销，相关的会员记录已经清除";
        else
            return "Sorry,似乎遇上了一些问题。";
    }

    /**
    *	检查是否已注册
    *
    *	@param $name 昵称
    *	@return bool
    */
    public function isLoged()
    {
    	$sql = "select * from Register_member where serverID = '{$this->ServerName}' and userID = '{$this->UserName}'";
        
        $this->db->query($sql);
        if($this->db->getRow())
            return TRUE;
        else
            return FALSE;
    }

    /**
    *    会员信息获取类
    *
    *    @param 无
    *    @return 返回信息
    */
    private function memberInfo()
    {

        $sql = "select * from Register_member where serverID = '{$this->ServerName}' and userID = '{$this->UserName}'";
        $this->db->query($sql);
        if($result = $this->db->getRow())
        {
            $reply['template'] = 'news';
            $reply['Articles'] = array();
            $reply['Articles'][0]['Title'] = "尊敬的会员{$result['name']}";//图文信息大标题

            $reply['Articles'][0]['PicUrl'] = "http://yuriserver.sinaapp.com/img/binfenfangcun.jpg";//大图链接
            $reply['Articles'][0]['Url'] = "http://www.dianping.com/shop/10350988";

            $reply['Articles'][1]['Title'] = "您于{$result['inTime']}注册了会员，迄今我们已相伴".$this->timeDiff(strtotime($result['inTime']))."了";
            $reply['Articles'][1]['Url'] = "http://www.dianping.com/shop/10350988";

                $sql = "select * from Register_rank where serverID = '{$this->ServerName}' and rank={$result['rank']}";
                $this->db->query($sql);
                if($rankInfo = $this->db->getRow())//如果能获取到会员等级信息的话
                {
                    $reply['Articles'][2]['Title'] = "您当前的会员等级为:\n=☆{$rankInfo['rankName']}☆=";
                    $reply['Articles'][2]['Url'] = "http://www.dianping.com/shop/10350988";
                    $reply['Articles'][3]['Title'] = "您可以享受的特权有:\n\n{$rankInfo['info']}";
                    $reply['Articles'][3]['Url'] = "http://www.dianping.com/shop/10350988";
                }
            $reply['Articles'][4]['Title'] = "出示此信息给店员，即可立即享受您的特权。";
            $reply['Articles'][4]['Url'] = "http://www.dianping.com/shop/10350988";
        }
        else
        {
            $reply['template'] = 'text';
            $reply['Content'] = "很抱歉您还不是会员";
        }

        return $reply;
    }

    /**
    *    时间差计算函数
    *
    *    @param Unix时间戳
    *    @return 返回信息
    */
    private function timeDiff($time)
    {
        $timeCurrent=time();
        $timeDiff=abs($timeCurrent-$time);//取时间差的绝对值
        $second=floor($timeDiff);//相差秒数
        $minite=floor($timeDiff/60);//相差分钟数
        $hour=floor($timeDiff/3600);//相差小时数
        $day=floor($timeDiff/3600/24);//相差天数
        $month=floor($timeDiff/3600/24/30);//相差月数
        $year=floor($timeDiff/3600/24/365);//相差年数
        if($year>0){
            return $year."年";
        }
        elseif($month>0){
            return $month."月";
        }
        elseif($day>0){
            return $day."天";
        }
        elseif($hour>0){
            return $hour."小时";
        }
        elseif($minite>0){
            return $minite."分钟";
        }
        elseif($second>0){
            return $second."秒";
        }
    }

}

?>