<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改banner图片</title>
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
	// area:['800px','270px'],  //图片的宽度和高度
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
<div class="formHeader"> <span class="title">修改banner图片</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<?php
$row = $dosql->GetOne("SELECT * FROM `pmw_banner` WHERE id=$id");
?>
<form name="form" id="form" method="post" action="banner_save.php" onsubmit="return quan();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

<!--	<tr>
		<td height="40" align="right">栏目分类：</td>
		<td colspan="2">
			<select class="input" name="typename" id="typename" style="width:508px;">
           <option <?php if($row['typename']=="index"){ echo "selected='selected'";}?> value="index">首页Banner图片</option>
           <option <?php if($row['typename']=="travel"){ echo "selected='selected'";}?> value="travel">行程Banner图片</option>
           <option <?php if($row['typename']=="piao"){ echo "selected='selected'";}?> value="piao">票务Banner图片</option>
           <option <?php if($row['typename']=="guide"){ echo "selected='selected'";}?> value="guide">导游Banner图片</option>
         </select></td>
	</tr>
  <tr>
    <td height="40" align="right">图片类型：</td>
    <td colspan="2" class="num" style="font-weight:bold;font-size:14px;color:red;"><?php echo $typename; ?></td>
  </tr>-->
		<tr>
		  <td height="40" align="right">图片标题：</td>
		  <td colspan="2"><input type="text" name="title" id="title" class="input" value="<?php echo $row['title'];?>"/></td>
    </tr>

	<tr>
			<td width="9%" height="75" align="right">banner图片：</td>
			<td width="8%" align="center"><img  width="100" height="50" style="cursor:pointer; padding:5px;border-radius:3px;" layer-src="<?php echo $row['pic']; ?>" onclick="message('<?php echo $row['id']; ?>');"
			src="<?php echo $cfg_weburl."/".$row['pic']; ?>" alt="<?php echo $row['title']; ?>" /></td>
			<td width="83%"></div>
   <input style="margin-top:5px;width:390px;" type="text" name="pic" id="pic" class="input" value="<?php echo $row['pic']; ?>" />
	 <span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,20971520,'pic')">上 传</span></span></td>
		</tr>
    <tr id="pictures" >
             <td height="40" align="right">添加内容：</td>
             <td colspan="2"> <textarea style="padding:5px;" name="content" id="content" class="kindeditor"><?php echo $row['content']; ?></textarea>
               <script>
         var editor;
         KindEditor.ready(function(K) {
           editor = K.create('textarea[name="content"]', {
             allowFileManager : true,
             width:'80%',
             height:'200px',
             extraFileUploadParams : {
               sessionid :  '<?php echo session_id(); ?>'
             }
           });
         });
         </script>
        <span class="num" style="color:red;font-weight:bold; padding:5px; font-size:18px;" >编辑器里面的图片最大宽度为375，请在编辑器添加图片的时候修改图片的宽度！！!</span>
       </td>
           </tr>
   	<tr>
        	  <td height="40" align="right">更新时间：</td>
        	  <td colspan="2"> <input type="text" name="pictime" id="pictime" class="inputms" value="<?php echo GetDateTime(time()); ?>" />
        	    <script type="text/javascript" src="plugin/calendar/calendar.js"></script>
       	      <script type="text/javascript">
				Calendar.setup({
					inputField     :    "pictime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
       	  </tr>
          <tr>
        	  <td height="86" align="right"></td>
        	  <td colspan="2"> <div class="formSubBtn" style="float:left; margin-bottom:30px;">
         <input type="submit" class="submit" value="保存" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update" />
    <input type="hidden" name="id" id="id" value="<?php echo $row['id'];?>" />
    <input type="hidden" name="type" id="type" value="<?php echo $type;?>" />
  </div></td>
       	  </tr>
  </table>

</form>
</body>
</html>
