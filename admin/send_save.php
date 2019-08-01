<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('weblink');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 18:08:58
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__weixin_news';
$gourl  = 'water.php';
$action = isset($action) ? $action : '';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');

//发送模板消息
 if($action == 'add_post')
{

	$posttime = GetMkTime($posttime);

  $messagetype="system";

  $stitle="系统消息";

  $title="系统提醒";


  //如果给旅行社发送模板消息，则先将系统发送的消息保存到数据库中来，然后再来发送模板消息
       if($type=="agency"){
       $tbname="pmw_agency";
       }elseif($type=="guide"){
       $tbname="pmw_guide";
       }

       $dosql->Execute("SELECT id,openid FROM $tbname where checkinfo=1");
       while($row=$dosql->GetArray()){
       $mid = $row['id'];  //旅行社或者导游的id
       $openid = $row['openid'];

       $sql = "INSERT INTO pmw_message (type,messagetype,content,stitle,title,mid,faxtime) VALUES ('$type', '$messagetype', '$content','$stitle', '$title', $mid, $posttime);";
        $dosql->ExecNoneQuery($sql);

       //发送模板消息
       $formid=getformid($openid);

       send_template_message($openid,$cfg_system_template_message,$linkurl,$formid,$cfg_contact_name,$cfg_contact_tel,$content,$cfg_appid,$cfg_appsecret);

       del_formid($formid,$openid);
       
       }
    echo 1;  //发送信息成功之后的返回值
}

//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>
