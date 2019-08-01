<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>往用户关注的微信小程序发送拒绝通过的消息</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getjcrop.js"></script>
<script type="text/javascript" src="templates/js/getinfosrc.js"></script>
<script type="text/javascript" src="plugin/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<style>
.input {
    width: 325px;
    height: 35px;
    border-radius: 3px;
}
.input1 {    width: 280px;
    height: 35px;
    border-radius: 3px;
}
.input2 {    width: 325px;
    height: 35px;
    border-radius: 3px;
}
</style>
</head>
<body>
<?php
//初始化参数
$adminlevel=$_SESSION['adminlevel'];
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title" style="text-align:center;">发送审核未通过消息</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<?php
if($type=="agency"){
$s=$dosql->GetOne("select * from `#@__agency` where id=$id");
$tp="旅行社";
$name=$s['company'];
$tel=$s['tel'];
$applytime=date("Y-m-d H:i:s",$s['regtime']);
$pic="您的营业执照";
}elseif($type=="guide"){
$r=$dosql->GetOne("select * from `#@__guide` where id=$id");
$tp="导游";	
$name=$r['name'];
$tel=$r['tel'];
$applytime=date("Y-m-d H:i:s",$r['regtime']);
$pic="您的导游证件";
}
?>
<form name="form" id="form" method="post" action="agency_save.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td width="22%" height="40" align="right">账户类型：</td>
		  <td><input type="text" name="tp" id="tp" value="<?php echo $tp;?>" readonly="readonly" class="input"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">企业名称：</td>
		  <td><input type="text" name="name" id="name" value="<?php echo $name;?>" readonly="readonly" class="input"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">手机号码：</td>
		  <td><input type="text" name="tel" id="tel" value="<?php echo $tel;?>" readonly="readonly" class="input"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">审核状态：</td>
		  <td width="78%"><input type="text" name="state" id="state" value="未通过" readonly="readonly" class="input"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">失败原因：</td>
		  <td><textarea name="content" id="content" class="textarea" style="padding:5px;">亲爱的会员您好，您申请的<?php echo $tp;?>注册信息未通过审核，由于<?php echo $pic;?>不够清晰，请重新填写资料注册！</textarea></td>
    </tr>
		<tr>
		  <td height="40" align="right">申请时间：</td>
		  <td><input type="text" name="applytime" id="applytime" value="<?php echo $applytime;?>" readonly="readonly" class="input"/></td>
    </tr>
		
		<tr>
		  <td height="40" align="right">审核时间：</td>
		  <td><input type="text" name="sendtime" id="sendtime" class="inputms" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
				<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
		  <script type="text/javascript">
				Calendar.setup({
					inputField     :    "sendtime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
    </tr>
      <tr>
		  <td height="40" align="right">&nbsp;</td>
		  <td><div class="formSubBtn" style="float:left; margin-left:1px;margin-top: 15px;">
            <input type="submit" class="submit" value="发送" />
    		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
    		<input type="hidden" name="action" id="action" value="checkfailed" />
      <input type="hidden" name="type" id="type" value="<?php echo $type;?>" />
      <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
  </div></td>
    </tr>
  </table>
	
</form>
</body>
</html>
