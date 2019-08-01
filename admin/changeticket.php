<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看下票人信息</title>
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
<script>
function closes(){
	
  var index=parent.layer.getFrameIndex(window.name);

parent.layer.close(index);
}

</script>
<body>
<?php
//初始化参数
$adminlevel=$_SESSION['adminlevel'];
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title" style="text-align:center;">查看下票人信息</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<?php
if($type=="agency"){
$s=$dosql->GetOne("select * from `#@__agency` where id=$id");
$tp="旅行社";
$name=$s['name'];
$tel=$s['tel'];
$company= $s['company'];

}elseif($type=="guide"){
$r=$dosql->GetOne("select * from `#@__guide` where id=$id");
$tp="导游";	
$name=$r['name'];
$tel=$r['tel'];
$company=$r['name'];

}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td width="22%" height="40" align="right">下票人类型：</td>
		  <td width="78%"><input type="text" name="tp" id="tp" value="<?php echo $tp;?>" readonly="readonly" class="input"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">下票人单位：</td>
		  <td><input type="text" name="name" id="name" value="<?php echo $company;?>" readonly="readonly" class="input"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">下票人电话：</td>
		  <td><input type="text" name="tel" id="tel" value="<?php echo $tel;?>" readonly="readonly" class="input"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">下票人姓名：</td>
		  <td><input type="text" name="applytime" id="applytime" value="<?php echo $name;?>" readonly="readonly" class="input"/></td>
    </tr>
      <tr>
		  <td height="40" align="right">&nbsp;</td>
		  <td><div class="formSubBtn" style="float:left; margin-left:1px;margin-top: 15px;">
            <input type="submit" class="submit" value="关闭" onclick="return closes();"/>
    		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
  </div></td>
    </tr>
  </table>
</body>
</html>
