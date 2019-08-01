<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发送模板消息结果通知</title>
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
<script>
function closes(){

var index=parent.layer.getFrameIndex(window.name);
window.parent.location.reload(); //刷新父页面
parent.layer.close(index);      //关闭当前的弹窗
}

</script>
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
<?php
$r=$dosql->GetOne("SELECT * FROM pmw_agency_message WHERE id=$mid");
?>
<?php if($state=="success"){?>
<div class="topToolbar"> <span class="title" style="text-align:center;">模板消息发送成功</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td width="22%" height="40" align="right">账户类型：</td>
		  <td><?php echo $r['tp'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">企业名称：</td>
		  <td><?php echo $r['name'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">手机号码：</td>
		  <td><?php echo $r['tel'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">审核状态：</td>
		  <td width="78%"><?php echo $r['state'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">温馨提示：</td>
		  <td><?php echo $r['content'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">申请时间：</td>
		  <td><?php echo $r['applytime'];?></td>
    </tr>

		<tr>
		  <td height="40" align="right">审核时间：</td>
		  <td><?php echo $r['sendtime'];?></td>
    </tr>
    <tr>
		  <td height="40" colspan="2" align="center" class="num" style="color:#0095ff; font-weight:bold;">注册信息已设置为未通过，当前的模板消息发送成功！</td>
    </tr>
    <tr>
  <td height="40" colspan="2" align="center" class="num" style="color:#0095ff; font-weight:bold;">  <input type="submit" class="submit" value="关闭" onclick="return closes();"/></td>
    </tr>
</table>

<?php }elseif($state=="failed"){?>
<div class="topToolbar"> <span class="title" style="text-align:center;">模板消息发送失败</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td width="22%" height="40" align="right">账户类型：</td>
		  <td><?php echo $r['tp'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">企业名称：</td>
		  <td><?php echo $r['name'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">手机号码：</td>
		  <td><?php echo $r['tel'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">审核状态：</td>
		  <td width="78%"><?php echo $r['state'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">失败原因：</td>
		  <td><?php echo $r['content'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">申请时间：</td>
		  <td><?php echo $r['applytime'];?></td>
    </tr>

		<tr>
		  <td height="40" align="right">审核时间：</td>
		  <td><?php echo $r['sendtime'];?></td>
    </tr>

    <tr>
		  <td height="40" colspan="2" align="center" class="num" style="color:red; font-weight:bold;">注册信息已设置为未通过，当前的模板消息发送失败！</td>
    </tr>
    <tr>
  <td height="40" colspan="2" align="center" class="num" style="color:#0095ff; font-weight:bold;">  <input type="submit" class="submit" value="点击关闭" style="border-color: #4898d5;
   background-color: #2e8ded;color: #fff;height: 28px;
line-height: 28px;
margin: 6px 6px 0;
padding: 0 15px;
border: 1px solid #dedede;
    border-top-color: rgb(222, 222, 222);
    border-right-color: rgb(222, 222, 222);
    border-bottom-color: rgb(222, 222, 222);
    border-left-color: rgb(222, 222, 222);
background-color: #f1f1f1;
color: #333;
border-radius: 2px;
font-weight: 400;
cursor: pointer;
text-decoration: none;" onclick="return closes();"/></td>
    </tr>
</table>

<?php }?>

</body>
</html>
