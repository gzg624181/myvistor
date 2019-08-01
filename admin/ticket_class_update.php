<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('admanage'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改景区分类</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="layui/layui.js"></script>
<link href="layui/css/layui.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
//初始化参数
$action  = isset($action)  ? $action  : 'ticket_save.php';
$tbname='pmw_ticketclass';
$r=$dosql->GetOne("SELECT * from $tbname where id=$id");
?>
<div class="formHeader"> <span class="title" style="margin-left: 13px;">修改景区分类</span> <a href="javascript:location.reload();" class="reload"><i class="fa fa-refresh fa-spin fa-fw"></i></a> </div>
<form name="form" id="form" method="post" action="<?php echo $action;?>">
	<table id="table1"  width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable" >
         <tr>
			<td width="28%" height="40" align="right">分类标题：</td>
			<td colspan="2">
			  <input type="text" class="input" id="title" name="title" required="required" value="<?php echo $r['title'];?>">
			  <span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>		    </td>
		</tr>
                <tr>
			<td height="40" align="right">分类图标：</td>
			<td width="4%" align="center"><img style="border-radius:3px; width:40px;" src="<?php echo $cfg_weburl."/".$r['icon'];?>" /></td>
			<td width="68%">
              <input style="margin-top:5px; width:446px;" type="text" name="icon" id="icon" class="input"  required="required"
               value="<?php echo $r['icon'];?>"/>
				<span class="cnote">
          <span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,20971520,'icon')">上 传</span>
             </td>
		</tr>
		<tr>
			<td height="40" align="right">添加时间：</td>
			<td colspan="2"><input type="text" name="posttime" id="posttime" class="input" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
		    <script type="text/javascript">
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update_ticket_class" />
        <input type="hidden" name="id" value="<?php echo $id;?>" id="id" />
  </div>
</form>

</body>
</html>
