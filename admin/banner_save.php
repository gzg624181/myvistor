<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 17:22:45
person: Feng
**************************
*/


//初始化参数
$tbname = 'pmw_banner';
$gourl  = 'bannerss.php';



//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加首页banner图片
if($action == 'add')
{

// 	if($type=="reg"){
// 		//注册的banner、图片
// 		$sql = "INSERT INTO `$tbname` (title, pic, type, pictime,typename) VALUES ('$title','$pic', '$type','$pictime','$typename')";
//
// 	}elseif($type=="text"){
//     $content=stripslashes($content);
//     $content1=rePic($content, $cfg_weburl);
// 		$sql = "INSERT INTO `$tbname` (title, pic, type,content, pictime,typename) VALUES ('$title','$pic', '$type','$content1','$pictime','$typename')";
//
// 	}elseif($type=="ticket"){
//
// 	$sql = "INSERT INTO `$tbname` (title, pic,type, linkurl, pictime,typename) VALUES ('$title','$pic', '$type','$linkurl','$pictime','$typename')";
//
// }elseif($type=="no"){
//     	$sql = "INSERT INTO `$tbname` (title, pic, type, pictime,typename) VALUES ('$title','$pic', '$type','$pictime','$typename')";
// }
  $pictime= strtotime($pictime);
	$sql = "INSERT INTO `$tbname` (title, pic,content,pictime) VALUES ('$title','$pic','$content', $pictime)";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}

}
else if($action=="TypeChange"){

echo $type;

}
//修改banner图片
else if($action == 'update')
{
	$pictime=strtotime($pictime);
//   if($type=="reg" || $type=="no"){
// 	$sql = "UPDATE `$tbname` SET title='$title',pictime=$pictime, pic='$pic',typename='$typename' WHERE id=$id";
// }elseif($type=="ticket"){
//   $sql = "UPDATE `$tbname` SET title='$title',pictime=$pictime, pic='$pic',typename='$typename',linkurl='$linkurl' WHERE id=$id";
// }elseif($type=="text"){
//   $sql = "UPDATE `$tbname` SET title='$title',pictime=$pictime, pic='$pic',typename='$typename',content='$content' WHERE id=$id";
// }
$sql = "UPDATE `$tbname` SET title='$title',pictime=$pictime, pic='$pic', content = '$content' WHERE id=$id";

	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}else if($action == 'del3')
{
	$tbname = 'pmw_question';
	$gourl="question.php";
	$dosql->QueryNone("DELETE FROM `$tbname` WHERE id=$id");
  header("location:$gourl");
  exit();
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>
