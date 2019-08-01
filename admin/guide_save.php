<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 17:16:14
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__guide';
$gourl  = 'guide.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');

//修改导游信息
if($action == 'update')
{

  if(!isset($picarr))        $picarr = '';
//合同组图
  if(is_array($picarr))
  {
    $picarrNum = count($picarr);
    $picarrTmp = '';

    for($i=0;$i< $picarrNum;$i++)
    {
      $picarrTmp[] = $picarr[$i];
    }

    $picarr = json_encode($picarrTmp);
  }

  $ymdtime=substr($regtime,0,10);
  $regtime=strtotime($regtime);



  if($password==""){ //密码不修改
    $sql = "UPDATE `$tbname` SET name='$name', agreement='$picarr', sex=$sex,card = '$card', cardnumber='$cardnumber', images='$images', content='$content',regtime=$regtime,ymdtime='$ymdtime' WHERE id=$id";
  }else{
    $password=md5(md5($password));
    $sql = "UPDATE `$tbname` SET name='$name',agreement='$picarr', sex=$sex,card = '$card', cardnumber='$cardnumber', images='$images', password='$password', content='$content',regtime=$regtime,ymdtime='$ymdtime' WHERE id=$id";
  }

	if($dosql->ExecNoneQuery($sql))
	{

		header("location:$gourl");
		exit();
	}
}
//ajax获取导游简介
else if($action == 'checkguide')
{
  if($type=="content"){
  $r=$dosql->GetOne("SELECT content FROM pmw_publish WHERE id=$id");
  $content = $r['content'];
  echo $content;

  }elseif($type=="pic"){
  $r=$dosql->GetOne("SELECT pic FROM pmw_publish WHERE id=$id");
  $contents = $cfg_weburl."/".$r['pic'];
  $content = "<img src='".$contents."' width=90% style='margin-top:17px;margin-bottom:8px;border-radius:3px;'><br>";
  echo $content;
  }

  elseif($type=="qrcode"){
  $r=$dosql->GetOne("SELECT qrcode FROM pmw_publish WHERE id=$id");
  $contents = $cfg_weburl."/".$r['qrcode'];
  $content = "<img src='".$contents."' width=90% style='margin-top:17px;margin-bottom:8px;border-radius:3px;'><br>";
  echo $content;
  }
}

else if($action=="del5"){
//删除空闲时间
$dosql->ExecNoneQuery("DELETE FROM pmw_freetime WHERE id=$id");
$gourl="free_time.php";
header("location:$gourl");
exit();

}
else if($action=="del22"){
//删除空闲时间
$dosql->ExecNoneQuery("DELETE FROM pmw_publish WHERE id=$id and openid='$openid'");
//$dosql->ExecNoneQuery("DELETE FROM pmw_record where poster_id=$id and member_openid='$openid'");
$gourl="guide.php";
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
