<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>实际取票人数更新成功！</title>
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
  
  window.parent.location.reload(); //刷新父页面
}

</script>
<body>
<?php
//初始化参数
$adminlevel=$_SESSION['adminlevel'];
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title" style="text-align:center;">实际取票人数更新成功！</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>

<form name="form" id="form" method="post" action="allorder_save.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td height="122" colspan="2" align="center" class="num" style="color:#06F; font-weight:bold; font-size:18px;">实际取票人数，实际支付总金额更新成功！</td>
    </tr>
      <tr>
		  <td width="42%" height="40" align="right">&nbsp;</td>
		  <td width="58%"><div class="formSubBtn" style="float:left; margin-left:1px;margin-top: 15px;">
            <input type="submit" class="submit" value="关闭" onclick="return closes();"/>
  </div></td>
    </tr>
  </table>
  </form>
</body>
</html>
