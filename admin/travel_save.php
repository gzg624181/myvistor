<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2017 phpMyWind.com
update: 2014-5-30 17:22:45
person: Feng
**************************
*/


//初始化参数
$tbname = 'pmw_travel';
$gourl  = 'travel_list.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//发布活动行程
if($action == 'add')
{

	$posttime=time();  //添加时间
	$fabu_y=date("Y");
	$fabu_ym=date("Y-m");
	$arr=array();
	$arr = explode(" -- ",$time);
	$endtime = strtotime($arr[1]);
	$starttimes = strtotime($arr[0]);
	$starttime_ymd=date("Y-m-d",$starttimes);
	$days=($endtime-$starttimes) / (60 * 60 * 24) +1;  //行程的天数
	$jiesuanmoney = $cfg_jiesuan * $days;


  $contents= add_travel($_POST);
	$r=$dosql->GetOne("SELECT company from pmw_agency where id=$aid");
	$company=$r['company'];
	$sql = "INSERT INTO `#@__travel` (title,starttime,starttime_ymd,endtime,num,origin,content,money,other,posttime,fabu_y, fabu_ym, aid,jiesuanmoney,company,days) VALUES ('$title',$starttimes,'$starttime_ymd',$endtime,$num,'$origin','$contents',$money,'$other',$posttime,'$fabu_y', '$fabu_ym',$aid,'$jiesuanmoney','$company',$days)";
		if($dosql->ExecNoneQuery($sql))
		{
			header("location:$gourl");
			exit();
		}
}
elseif($action=="update"){

	$posttime=strtotime($posttime);  //更新时间
	$arr=array();
	$arr = explode(" -- ",$time);
	$endtime = strtotime($arr[1]);
	$starttimes = strtotime($arr[0]);
	$day=($endtime-$starttimes) / (60 * 60 * 24) +1;  //行程的天数
	$jiesuanmoney = $cfg_jiesuan * $day;

	$content=add_travel($_POST);
	$sql = "UPDATE `$tbname` SET title='$title', starttime=$starttimes,endtime=$endtime,num=$num,origin='$origin',money='$money',jiesuanmoney='$jiesuanmoney',other='$other',posttime=$posttime,content='$content' WHERE `id`=$id";

	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
	  exit();
	}
}

//结算旅行社发送的月份账单
else if($action=="jiesuan")
{

	 $m =$y."-".$m;
	 $sql ="UPDATE `$tbname` SET  Settlement='YES' WHERE aid=$id and state=2 and complete_y='$y' and complete_ym='$m'";
	 if($dosql->ExecNoneQuery($sql))
 	{
		jiesuan($id,$y,$m);
		$gourls="jiesuan_month.php?id=".$id."&y=".$y;
 	//	header("location:$gourls");
		ShowMsg($m."月账单结算成功！",$gourls);
 	  exit();
 	}
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>
