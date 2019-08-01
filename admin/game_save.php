<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('job');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 17:09:57
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__gameplay';
$gourl  = 'playgame.php';
$action = isset($action) ? $action : '';


//引入处理类
require_once(ADMIN_INC.'/action.class.php');


//添加游戏赔率
if($action == 'add')
{

  if($typename=="大小单双"){
    $typename_name=0;
  }elseif($typename=="猜数字"){
    $typename_name=1;
  }elseif($typename=="特殊玩法"){
    $typename_name=2;
  }

  $addtime=time();
  if($typename=="大小单双"){
    	$sql = "INSERT INTO `$tbname` (gid, name, typename,typename_name, da, xiao, dan, shuang, jida, dadan, xiaodan, dashuang, xiaoshuang, jixiao,content,addtime) VALUES ($gid, '$name', '$typename', '$typename_name', '$da', '$xiao', '$dan', '$shuang', '$jida', '$dadan', '$xiaodan', '$dashuang', '$xiaoshuang', '$jixiao','$content',$addtime)";
  }elseif($typename=="猜数字"){
    	$sql = "INSERT INTO `$tbname` (gid, name, typename,typename_name, zero, one, two, three, four, five, six, seven, eight, night,ten,one_one,one_two,one_three,one_four,one_five,one_six,one_seven,one_eight,one_night,two_zero,two_one,two_two,two_three,two_four,two_five,two_six,two_seven,content,addtime) VALUES ($gid, '$name', '$typename','$typename', '$zero', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$night','$ten','$one_one', '$one_two', '$one_three','$one_four', '$one_five', '$one_six', '$one_seven','$one_eight','$one_night', '$two_zero', '$two_one','$two_two','$two_three','$two_four', '$two_five', '$two_six','$two_seven','$content',$addtime)";

  }elseif($typename=="特殊玩法"){
    	$sql = "INSERT INTO `$tbname` (gid, name, typename, baozi, shunzi, duizi, drgon, hu, bao, content,addtime) VALUES ($gid, '$name', '$typename', '$baozi', '$shunzi', '$duizi', '$long', '$hu', '$bao', '$content',$addtime)";
  }

	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}

if($action=="add_kuaitou"){
  $addtime=time();
  $tbname="pmw_kuaitou";
  $sql = "INSERT INTO `$tbname` (name, content,addtime) VALUES ('$name', '$content',$addtime)";
  if($dosql->ExecNoneQuery($sql))
	{
    $gourl="kuaitou.php";
		header("location:$gourl");
		exit();
	}
}

if($action="update_kuaitou"){
  $tbname="pmw_kuaitou";
  $sql = "UPDATE `$tbname` SET name='$name', content='$content' WHERE id=$id";
 if($dosql->ExecNoneQuery($sql))
 {
   $gourl="kuaitou.php";
   header("location:$gourl");
   exit();
 }
}

if($action == 'del6'){
	$tbname= "pmw_kuaitou";
	$gourls = "kuaitou.php";
	$sql = "delete  from `$tbname` where id=$id";
	$dosql->ExecNoneQuery($sql);
	header("location:$gourls");
	exit();
}

//修改招聘信息
if($action == 'update')
{
	$posttime = GetMkTime($posttime);

	$sql = "UPDATE `$tbname` SET siteid='$cfg_siteid', title='$title', jobplace='$jobplace', jobdescription='$jobdescription', employ='$employ', jobsex='$jobsex', treatment='$treatment', usefullife='$usefullife', experience='$experience', education='$education', joblang='$joblang', workdesc='$workdesc', content='$content', orderid='$orderid', posttime='$posttime', checkinfo='$checkinfo' WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}
//ajax获取游戏详细介绍
if($action == 'checkcontent')
{
	$r=$dosql->GetOne("SELECT gamedescription FROM `pmw_game` WHERE id=$id");
       $gamedescription=$r['gamedescription'];
	echo $gamedescription;
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>
