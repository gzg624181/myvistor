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
<script type="text/javascript" src="layer/layer.js"></script>
<script>

function message(Id){
  // alert(Id);
   layer.ready(function(){ //为了layer.ext.js加载完毕再执行
   layer.photos({
   photos: '#layer-photos-demo_'+Id,
	// area:['300px','270px'],  //图片的宽度和高度
   shift: 0 ,//0-6的选择，指定弹出图片动画类型，默认随机
   closeBtn:1,
   offset:'40px',  //离上方的距离
   shadeClose:false
  });
});
}

</script>
</head>
<body>
<div class="formHeader"> <span class="title">音频分享设置</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<?php
$r=$dosql->GetOne("SELECT * FROM pmw_share where id=2");
 ?>
<form name="form" id="form" method="post" action="music_save.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

  <tr>
  <td width="15%" height="40" align="right">分享小图标图片：</td>
  <td width="6%"><img  width="100px;" layer-src="<?php echo $r['tubiaopic'];?>" style="cursor:pointer; padding:8px; border-radius:12px;" src="<?php echo $cfg_weburl."/".$r['tubiaopic'];?>"/></td>
  <td width="79%">

    <input style="margin-top:5px;" type="text" name="tubiaopic" id="tubiaopic" class="input" value="<?php echo $r['tubiaopic']; ?>"  required="required"/>
  <span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,20971520,'tubiaopic')">上 传</span></span>
   </td>
  </tr>

<tr>
<td height="40" align="right">分享背景图片：</td>
<td> <img  width="100px;" layer-src="<?php echo $cfg_weburl."/".$r['imagesurl'];?>" style="cursor:pointer; padding:8px;border-radius:12px;" onclick="message('<?php echo $r['id']; ?>');"  src="<?php echo $cfg_weburl."/".$r['imagesurl'];?>"/></td>
<td>

  <input style="margin-top:-12px;" type="text" name="pic" id="pic" class="input" value="<?php echo $r['imagesurl']; ?>"  required="required"/>
<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,20971520,'pic')">上 传</span></span>
 </td>
</tr>
<tr>
<td height="40" align="right">分享图片实例：</td>
<td><div id="layer-photos-demo_<?php  echo $r['id'];?>" class="layer-photos-demo"> <img  width="100px;" layer-src="<?php echo $r['examplepic'];?>" style="cursor:pointer; padding:8px;border-radius:12px;" onclick="message('<?php echo $r['id']; ?>');"  src="<?php echo $r['examplepic'];?>"/></div></td>
<td class="num" style="color:red;">分享完成之后，生成的分享海报实例
 ，点击图片查看分享海报大图</td>
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
