<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改游戏</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript" src="templates/js/getarea.js"></script>
</head>
<body>
<?php
$r = $dosql->GetOne("SELECT * FROM `#@__lotterynumber` WHERE `id`=$id");
?>
<div class="formHeader">修改游戏<a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="lottery_save.php" onsubmit="return cfm_infolm();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td height="40" align="right">开奖期数：</td>
		  <td width="64%" colspan="11"><input type="text" name="kj_times" id="kj_times" readonly="readonly" class="input"  value="<?php echo $r['kj_times'];?>"/></td>
    </tr>
		<tr>
			<td width="6%" height="40" align="right">开奖时间：</td>
			<td colspan="11"><input type="text" name="kj_endtime" id="kj_endtime" readonly="readonly" class="input" value="<?php echo $r['kj_endtime'];?>"/></td>
		</tr>
      <tr>
          <td height="40" align="right">开奖号码：</td>
          <td colspan="11" valign="middle"><input type="text" name="kj_number" id="kj_number" class="input" value="<?php echo $r['kj_number'];?>"/>
            (可后台修改）</td>
    </tr>
      <tr>
        <td height="40" align="right">排列排序：</td>
        <td width="18%"><input type="text" name="orderid" id="orderid" readonly="readonly" class="inputos" value="<?php echo GetOrderID('#@__game'); ?>" /></td>
      </tr>
      <tr>
      <td height="40" align="right">&nbsp;</td>
       <td><div class="formSubBtn" style="float:left; margin-top:5px;">
        <input type="submit" class="submit" value="保存" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update_lottery" />
		<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
  </div></td>
    </tr>
	</table>

</form>
</body>
</html>
