<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>手动后台充值</title>
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
</style>
<script>
function tuijian(){
     if($("#money").val() == "")
	{
		layer.alert("请输入充值金额！",{icon:2});
		$("#money").focus();
		return false;
	}
	}
</script>
</head>
<body>
<?php
//初始化参数
$adminlevel=$_SESSION['adminlevel'];
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title" style="text-align:center;">后台手动充值上分</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<?php
$s=$dosql->GetOne("select * from `#@__members` where id=$id");
$qrcode=$s['qrcode'];
?>
<form name="form" id="form" method="post" action="member_save.php" onsubmit="return tuijian();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td height="40" align="right">充值会员UID：</td>
		  <td width="78%"><input type="text" name="ucode" id="ucode" value="<?php echo $s['ucode'];?>" readonly="readonly" class="input"/></td>
    </tr>
	<tr>
			<td width="22%" height="40" align="right">充值会员账号：</td>
			<td><input type="text" name="telephone" id="telephone" value="<?php echo $s['telephone'];?>" readonly="readonly" class="input"/></td>
	</tr>
  <tr>
  <td height="40" align="right">选择充值类型：</td>
  <td><select name="chargetype" id="chargetype" class="input" >
    <option value="0">后台充值</option>
    <option value="1">支付宝充值</option>
    <option value="2">微信充值</option>
    <option value="3">银联卡充值</option>
    <option value="4">云闪付充值</option>
  </select></td>
  </tr>
		<tr>
		  <td height="40" align="right">充值金额：</td>
		  <td><input type="text" name="money" id="money" placeholder="请输入充值金额" value="" class="input"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">充值时间：</td>
		  <td><input type="text" name="chargetime" id="chargetime" class="inputms" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
				<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
		  <script type="text/javascript">
				Calendar.setup({
					inputField     :    "chargetime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
    </tr>

  </table>
	<div class="formSubBtn" style="float:left; margin-left:95px;margin-top: 15px;">
         <input type="submit" class="submit" value="提交" />
    		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
    		<input type="hidden" name="action" id="action" value="charge" />
        <input type="hidden" name="bcode" id="bcode" value="<?php echo $s['bcode'];?>" />
        <input type="hidden" name="mid" id="mid" value="<?php echo $id;?>" />
  </div>
</form>
</body>
</html>
