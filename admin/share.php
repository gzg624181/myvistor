<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分享设置</title>
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
<script type="text/javascript" src="layui/layui.js"></script>
<link href="layui/css/layui.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="formHeader"> <span class="title">分享设置</span> <a href="javascript:location.reload();" class="reload"><?php echo $cfg_reload;?></a> </div>
<?php
$r=$dosql->GetOne("SELECT * FROM pmw_share where id=1");
 ?>
<form name="form" id="form" method="post" action="admin_save.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

		<tr>
		  <td width="11%" height="40" align="right">分享标题：</td>
		  <td colspan="3"><input type="text" name="title" id="title" class="input" value="<?php echo $r['title'];?>" required/></td>
    </tr>

<tr>
<td height="112" align="right">分享背景图片：</td>
<td width="9%" align="center"><img src="<?php echo $cfg_weburl."/".$r['imagesurl'];?>" width="100px;" style="border-radius:3px;"></td>
<td width="80%">
  
  <input style="margin-top:5px; width:380px;" type="text" name="pic" id="pic" class="input" value="<?php echo $r['imagesurl']; ?>"  required="required"/>
<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,20971520,'pic')">上 传</span></span>
 </td>
</tr>


    <tr>
    <td height="40" align="right"></td>
    <td colspan="3"> <div class="formSubBtn" style="float:left; margin-bottom:30px;">
    <input type="submit" class="submit" value="保存" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="share_update" />
   </div></td>
   </tr>
  </table>

</form>
</body>
</html>
