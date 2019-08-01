<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 17:22:45
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__message';
$gourl  = 'message.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//查看消息内容
if($action == 'checkmessage')
{

  $r=$dosql->GetOne("SELECT content,stitle FROM $tbname WHERE id=$id");
  $contents = $r['content'];
  $content =  "<span style='font-size:14px;font-weight:bold;margin-bottom:10px;'>".$r['stitle']."</span><br><br><br>";

  $arr=explode("|",$contents);
  for($i=0;$i<count($arr);$i++){
  $content .= $arr[$i]."<br><br>";
  }

	echo $content;
}




//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>
