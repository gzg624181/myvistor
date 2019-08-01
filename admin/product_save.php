<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2017 phpMyWind.com
update: 2014-5-30 17:22:45
person: Feng
**************************
*/


//初始化参数
$tbname = 'pmw_game';
$gourl  = 'product.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');





//添加游戏列表
if($action == 'add')
{
	  $gamepic = $cfg_weburl."/".$gamepic;
		$gametime=time();
		$sql = "INSERT INTO `$tbname` (gamename, game, gamepic, gamedescription, remark, gametypes, gametime, gameonline, orderid,zsticheng,ejticheng) VALUES ('$gamename', '$game', '$gamepic', '$gamedescription', '$remark', '$gametypes', $gametime, $gameonline, $orderid,'$zsticheng','$ejticheng')";
		if($dosql->ExecNoneQuery($sql))
		{
			header("location:$gourl");
			exit();
		}
}


//修改游戏简介
else if($action == 'update'){
  $gametime=time();
	if(strpos($gamepic,$cfg_weburl)!==false){
  $gamepics=$gamepic;
	}else{
	$gamepics=$cfg_weburl."/".$gamepic;
	}
	$sql = "UPDATE `$tbname` SET gamename='$gamename',game='$game',zsticheng='$zsticheng',ejticheng='$ejticheng',remark='$remark',gamepic='$gamepics',gamedescription='$gamedescription',gametypes='$gametypes',gameonline=$gameonline,orderid=$orderid,gametime=$gametime WHERE id=$id";

	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}

//上线游戏
elseif($action=="getup"){
	$sql = "UPDATE `pmw_game` SET gameonline=1 WHERE id=$id ";
	$dosql->ExecNoneQuery($sql);
echo "<font color='#339933'><B>"."<i class='fa fa-check' aria-hidden='true'></i>"."</b></font>";
}


  //上线游戏
elseif($action=="getdown"){
	$sql = "UPDATE `pmw_game` SET gameonline=0 WHERE id=$id ";
	$dosql->ExecNoneQuery($sql);
echo "<font color='#FF0000'><B>"."<i class='fa fa-times' aria-hidden='true'></i>"."</b></font>";
}

//删除游戏列表介绍
else if($action == 'del3'){
	$sql = "delete  from `$tbname` where id=$id";
	$dosql->ExecNoneQuery($sql);
	header("location:$gourl");
	exit();
}

//删除游戏玩法介绍
else if($action == 'del4'){
	$tbname= "pmw_gamedes";
	$gourl = "game_des";
	$sql = "delete  from `$tbname` where id=$id";
	$dosql->ExecNoneQuery($sql);
	header("location:$gourl");
	exit();
}


//ajax获取游戏玩法介绍
if($action == 'checkgamedes')
{
	$r=$dosql->GetOne("SELECT game_description FROM `pmw_gamedes` WHERE id=$id");
  $game_description = $r['game_description'];
	echo $game_description;
}

//修改游戏介绍
else if($action == 'update_gamedes'){
	$tbname= "pmw_gamedes";
	if(strpos($game_pic,$cfg_weburl)!==false){
  $game_pics=$game_pic;
	}else{
	$game_pics=$cfg_weburl."/".$game_pic;
	}
	$game_time = time();
	$sql = "UPDATE `$tbname` SET game_name='$game_name',game_pic='$game_pics',game_description='$game_description',game_time=$game_time WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
		$gourls="game_des.php";
		//ShowMsg("更新成功",$gourls);
		header("location:$gourls");
		exit();
	}
}
//添加游戏介绍
elseif($action == 'add_gamedes')
{
	  $game_pic = $cfg_weburl."/".$game_pic;
		$tbname= "pmw_gamedes";
		$game_time=time();
		$sql = "INSERT INTO `$tbname` (game_name, game_pic, game_description, game_time) VALUES ('$game_name','$game_pic', '$game_description',$game_time)";
		if($dosql->ExecNoneQuery($sql))
		{
			$gourls="game_des.php";
			header("location:$gourls");
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
