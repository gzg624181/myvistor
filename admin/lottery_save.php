<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 17:16:14
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__lotterynumber';
$gourl  = 'lottery.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');
date_default_timezone_set('PRC');

//生成开奖号码
if($action == 'add')
{
  //0-24点钟的开奖时间和日期 每3分钟半钟开奖一次，每两分半钟之后封盘 先生成500期 ，其实期数2417909  起始开奖时间 2019-04-24 03:01:00
  for($i=1;$i<501;$i++){
    $data="2019-04-24 03:01:00";
    $first_kjtimes="2417909";
    $startzero=strtotime($date);
    $next_times=$startzero+210 * $i;
    $kj_times=$firsttimes + $i;
    $kj_endtime=date("Y-m-d H:i:s",$next_times);
    $kj_endtime_sjc=strtotime($kj_endtime);
    $kj_mdhi=date("m-d H:i:s",$next_times);
    $sql = "INSERT INTO `$tbname` (kj_times,kj_endtime,kj_endtime_sjc,kj_mdhi) VALUES ($kj_times, '$kj_endtime','$kj_endtime_sjc', '$kj_mdhi')";
  	$dosql->ExecNoneQuery($sql);
  }
//测试数据=================================================================================//
// {
//   //0-6点钟的开奖时间和日期  ，开奖间隔2分钟
//   for($i=1;$i<601;$i++){
//     if($i<181){
//     $startzero=strtotime($date);
//     }else{
//     //10-0点开奖
//     $startzero=strtotime($date)+ 3600 * 4;
//     }
//     $next_times=$startzero+120 * $i;
//     $kj_date=date("Ymd",$next_times)."-".sprintf("%03d", $i);
//     $kj_times=$i;
//     $number=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9); //生成一个五位数的数字
//     $kj_number=sprintf("%05s", $number);
//     $kj_endtime=date("Y-m-d H:i:s",$next_times);
//     $kj_endtime_sjc=strtotime($kj_endtime);
//     $kj_maketime=$date;
//     $sql = "INSERT INTO `$tbname` (kj_date, kj_times, kj_number, kj_endtime,kj_endtime_sjc,kj_maketime) VALUES ('$kj_date', $kj_times, '$kj_number','$kj_endtime','$kj_endtime_sjc', '$kj_maketime')";
//   	$dosql->ExecNoneQuery($sql);
//   }
//测试数据=================================================================================//

  ShowMsg($date.'开奖号码生成成功！',$gourl);
  exit();

}
//修改会员信息
else if($action == 'update')
{


	$sql = "UPDATE `$tbname` SET ";
	if($password != '')
	{
		if($password != $repassword)
		{
			ShowMsg('两次输入的密码不一样！','-1');
			exit();
		}
		$password = md5(md5($password));
	  $sql = "update `#@__members` SET backpoint=$backpoint, password='$password', nickname='$nickname', money='$money', wecome='$wecome', checkinfo='$checkinfo' WHERE id=$id";
  }else{
		$sql = "update `#@__members` SET backpoint=$backpoint, nickname='$nickname', money='$money', wecome='$wecome', checkinfo=$checkinfo  WHERE id=$id";
 }

	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//移除绑定QQ
else if($action == 'update_lottery')
{
  $my_arr = str_split($kj_number);
  $kj_he = array_sum($my_arr);
  $var=results($kj_he);
  $kj_varchar =$my_arr[0]."+".$my_arr[1]."+".$my_arr[2]."=".$kj_he.$var;
	$dosql->ExecNoneQuery("UPDATE $tbname SET `kj_number`='$kj_number',kj_he=$kj_he,kj_varchar='$kj_varchar' WHERE `id`=$id");
	header("location:$gourl");
	exit();
}


//移除绑定微博
else if($action == 'removeoweibo')
{
	$dosql->ExecNoneQuery("UPDATE `#@__member` SET `weiboid`='' WHERE `id`='$id'");
	ShowMsg('解除微博绑定成功！','member_update.php?id='.$id);
	exit();
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>
