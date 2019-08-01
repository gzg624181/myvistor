<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员推荐二维码</title>
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
    width: 280px;
    height: 35px;
    border-radius: 3px;
}
</style>
<script>
function message(Id){
 //  alert(Id);
   layer.ready(function(){ //为了layer.ext.js加载完毕再执行
   layer.photos({
    photos: '#layer-photos-demo_'+Id,
	//area:['500px','300px'],  //图片的宽度和高度
    shift: 0 ,//0-6的选择，指定弹出图片动画类型，默认随机
	closeBtn:1,
	offset:'40px',  //离上方的距离
	shadeClose:true
  });
});
}
function tuijian(){
	if($("#adminlevel").val() !=1)
	{
		alert("亲，您还没有操作本模块的权限，请联系超级管理员！");
		$("#bilv").focus();
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
<div class="topToolbar"> <span class="title">会员推荐二维码：</span> <a title="刷新" href="javascript:location.reload();" class="reload"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<?php
$s=$dosql->GetOne("select * from `#@__members` where id=$id");
$qrcode=$s['qrcode'];
?>
<form name="form" id="form" method="post" action="erweima_tuijian_save.php" onsubmit="return tuijian();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td height="40" align="right">会员昵称：</td>
		  <td width="78%"><input type="text" name="nickname" id="nickname" value="<?php echo $s['nickname'];?>" readonly="readonly" class="input"/></td>
    </tr>
	<tr>
			<td width="22%" height="40" align="right">会员账号：</td>
			<td><input type="text" name="telephone" id="telephone" value="<?php echo $s['telephone'];?>" readonly="readonly" class="input"/></td>
	</tr>
		<tr>
			<td height="95" align="right">会员推荐二维码：</td>
			<td align="left" valign="middle"><div id="layer-photos-demo_<?php echo $s['id'];?>" class="layer-photos-demo"> 
            <img  width="120" height="110" layer-src="<?php echo $cfg_weburl."/".$s['qrcode'];?>" style="cursor:pointer" onclick="message('<?php echo $s['id']; ?>');"  src="<?php echo $cfg_weburl."/".$s['qrcode'];?>" alt="<?php echo $s['nickname']; ?>" /> </div></td>
	</tr>
		<tr>
		  <td height="40" align="right">推广链接：</td>
		  <td><input type="text" name="links"
		  <?php
		   if($_SESSION['adminlevel']!=1){echo "readonly='readonly'";}?>
		  id="links" value="<?php echo $s['links'];?>" class="input"/></td>
    </tr>

  </table>
	<div class="formSubBtn" style="float:left; margin-left:95px;margin-top: 15px;">
         <!--<input type="submit" class="submit" value="提交" />-->
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="huiyuan_update" />
        <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
  </div>
</form>
</body>
</html>
