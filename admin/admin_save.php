<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');
/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 10:46:30
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__admin';
$gourl  = 'admin.php';
$action = isset($action) ? $action : '';


//添加管理员
if($action == 'add')
{

	//只有超级管理员才有权创建超级管理员
	if($cfg_adminlevel > 1 and $levelname == 1)
	{
		ShowMsg('非法的操作，不能创建超级管理员！', '-1');
		exit();
	}


	//判断用户名是否合法
	if(preg_match("/[^0-9a-zA-Z_@!\.-]/",$username) ||
	   preg_match("/[^0-9a-zA-Z_@!\.-]/",$password))
	{
		ShowMsg('用户名或密码非法！请使用[0-9a-zA-Z_@!.-]内的字符！', '-1');
		exit();
	}


	//判断用户名是否存在
	if($dosql->GetOne("SELECT `id` FROM `$tbname` WHERE `username`='$username'"))
	{
		ShowMsg('用户名已存在！', '-1');
		exit();
	}


	$password  = md5(md5($password));
	$loginip   = '127.0.0.1';
	$logintime = time();

	$sql = "INSERT INTO `$tbname` (username, password, nickname, question, answer, levelname, checkadmin, loginip, logintime) VALUES ('$username', '$password', '$nickname', '$question', '$answer', '$levelname', '$checkadmin', '$loginip', '$logintime')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改管理员
else if($action == 'update')
{

	//创始人账号不允许更改状态
	if($id == 1 and ($checkadmin != 'true' or $levelname != '1'))
	{
		ShowMsg('抱歉，不能更改创始账号状态！','-1');
		exit();
	}


	//只有超级管理员才有权修改超级管理员
	if($cfg_adminlevel > 1 and $levelname == 1)
	{
		ShowMsg('非法的操作，不能修改为超级管理员！', '-1');
		exit();
	}


	if($password == '')
	{
		$sql = "UPDATE `$tbname` SET nickname='$nickname', question='$question', answer='$answer', levelname='$levelname', checkadmin='$checkadmin' WHERE `id`=$id";
	}
	else
	{
		$oldpwd   = md5(md5($oldpwd));
		$password = md5(md5($password));

		$r = $dosql->GetOne("SELECT `password` FROM `#@__admin` WHERE `id`=$id");
		if($r['password'] != $oldpwd)
		{
			ShowMsg('抱歉，旧密码错误！','-1');
			exit();
		}

		$sql = "UPDATE `$tbname` SET password='$password', nickname='$nickname', question='$question', answer='$answer', levelname='$levelname', checkadmin='$checkadmin' WHERE id=$id";
	}

	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}


//修改管理员审核状态
else if($action == 'check')
{

	if($id == 1)
	{
		ShowMsg('抱歉，不能更改创始账号状态！','-1');
		exit();
	}


	if($checkadmin == 'true')
		$sql = "UPDATE `$tbname` SET checkadmin='false' WHERE `id`=$id";
	if($checkadmin == 'false')
		$sql = "UPDATE `$tbname` SET checkadmin='true' WHERE `id`=$id";


	if($dosql->ExecNoneQuery($sql))
	{
    	header("location:$gourl");
		exit();
	}
}


//删除管理员
else if($action == 'del')
{
	if($id == 1)
	{
		ShowMsg('抱歉，不能删除创始账号！','-1');
		exit();
	}

	if($dosql->ExecNoneQuery("DELETE FROM `$tbname` WHERE `id`=$id"))
	{
    	header("location:$gourl");
		exit();
	}
}

else if($action=='sets'){
	//先将系统里面前面是购票管理员的修改掉
	$dosql->ExecNoneQuery("UPDATE pmw_members SET sets=0 where sets=1");
	//将更新后的购票管理员更新
	$dosql->ExecNoneQuery("UPDATE pmw_members SET sets=1 where id=$id");

	$gourl="members.php";

	header("LOCATION:$gourl");

}
else if($action=='change_checkpost'){
	//先将系统里面前面是购票管理员的修改掉
	if($checkpost==1){
	$dosql->ExecNoneQuery("UPDATE pmw_members SET checkpost=0 where id=$id");
	//将更新后的购票管理员更新
	}else{
		$dosql->ExecNoneQuery("UPDATE pmw_members SET checkpost=1 where id=$id");
	}

	$gourl="members.php";

	header("LOCATION:$gourl");

}
else if($action=='share_update'){
	// if(!check_str($pic,$cfg_weburl)){
  //   $pic=$cfg_weburl."/".$pic; //导游证件
  // }
	$dosql->ExecNoneQuery("UPDATE pmw_share SET title='$title',imagesurl='$pic' where id=1");
	$gourl="share.php";

	header("LOCATION:$gourl");
}
else if($action=="rules_update"){
	$dosql->ExecNoneQuery("UPDATE pmw_xieyi SET content='$content' where id=1");
	$gourl="rules.php";

	header("LOCATION:$gourl");
}else if($action=="change_vip"){
	$dosql->ExecNoneQuery("UPDATE pmw_members SET vip=1 where id=$id");
	$gourl="members.php";

	header("LOCATION:$gourl");
}
//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>
