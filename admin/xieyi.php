<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户协议</title>
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


</head>
<body>
<div class="formHeader"> <span class="title">用户协议</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<?php
$row=$dosql->GetOne("SELECT * FROM pmw_xieyi where id=1");
 ?>
<form name="form" id="form" method="post" action="admin_save.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

		<tr>
		  <td height="40" align="right">用户协议：</td>
		  <td colspan="2">用户协议书</td>
    </tr>

<tr>
<td height="40" align="right">协议内容：</td>
<td> <textarea <?php if($row['content']==""){ echo "readonly";}  ?>  name="content" id="content" class="kindeditor"><?php echo $row['content'];?></textarea>
       	      <script>
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="content"]', {
						allowFileManager : true,
						width:'100%',
						height:'400px',
						extraFileUploadParams : {
							sessionid :  '<?php echo session_id(); ?>'
						}
					});
				});
				</script>
 </td>
</tr>


    <tr>
    <td height="40" align="right"></td>
    <td colspan="2"> <div class="formSubBtn" style="float:left; margin-bottom:30px;">
    <input type="submit" class="submit" value="保存" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="xieyi_update" />
   </div></td>
   </tr>
  </table>

</form>
</body>
</html>
