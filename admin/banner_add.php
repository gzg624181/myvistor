<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加banner轮播图片</title>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script>

   //选择栏目分类

	 function SelectType() {



		 var options=$("#typename option:selected");

     var objvalue =options.val();

		 if(objvalue== -1){
			 layer.alert("请选择Banner图片分类",{icon:0});
			 return false;
		 }

		 var options=$("#type option:selected");

		 var objvalue =options.val();

		 if(objvalue== -1){
		 	layer.alert("请选择Banner图片分类",{icon:0});

			return false;
		 }

	 }

//更改添加图片的类型
	 function TypeChange(){

	 var options=$("#type option:selected");

   var objvalue =options.val();

   if(objvalue== -1){
		 layer.alert("请选择Banner图片分类",{icon:0});
	 }else{
	 var ajax_url = "banner_save.php?action=TypeChange&type=" + objvalue;
   }
	 //alert(url);

	$.ajax({
    url:ajax_url,
    type:'get',
	data: "data" ,
	dataType:'html',
    success:function(data){
			var urlss = document.getElementById("urlss");
			var pictures = document.getElementById("pictures");

       if(data=="text"){
				 pictures.style.display = "";
         urlss.style.display = "none";
			 }else if(data =="ticket"){
				 pictures.style.display = "none";
	 			 urlss.style.display = "";
			 }else{
				 pictures.style.display = "none";
	 			 urlss.style.display = "none";
			 }

    } ,
	error:function(){
       alert('error');
    }
	});

}
</script>

</head>
<body>
<div class="formHeader"> <span class="title">添加Banner轮播图片</span> <a href="javascript:location.reload();" class="reload"><?php echo $cfg_reload;?></a> </div>
<form name="form" id="form" method="post" action="banner_save.php" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

	<!--<tr>
		<td height="40" align="right">栏目分类：</td>
		<td colspan="2">
 <select class="input" name="typename" id="typename" style="width:508px;">
	   <option value="-1">请选择栏目分类</option>
		 <option value="index">首页Banner图片</option>
		 <option value="travel">行程Banner图片</option>
		 <option value="piao">票务Banner图片</option>
		 <option value="guide">导游Banner图片</option>
 </select>
	<span class="maroon">*</span><span class="maroon" style="font-weight:bold;">请选择Banner图片栏目</span>
		</td>
	</tr>-->

		<tr>
		  <td height="40" align="right">图片标题：</td>
		  <td colspan="2"><input type="text" name="title" id="title" class="input" required/></td>
        </tr>

		<!--<tr>
			<td height="40" align="right">图片分类：</td>
			<td colspan="2">
   <select class="input" name="type" id="type" style="width:508px;" onchange="TypeChange();">
   	   <option value="-1">请选择图片分类</option>
			 <option value="ticket">景区</option>
			 <option value="reg">注册</option>
			 <option value="text">文本介绍</option>
			 <option value="no">无跳转链接</option>
   </select>
			</td>
		</tr>-->

<tr>
<td height="40" align="right">banner图片：</td>
<td><input style="margin-top:5px;" type="text" name="pic" id="pic" class="input"  required="required"/>
<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,20971520,'pic')">上 传</span></span>
 </td>
</tr>

   <tr id="pictures" >
        	  <td height="40" align="right">添加内容：</td>
        	  <td colspan="2"> <textarea style="padding:5px;" name="content" id="content" class="kindeditor"></textarea>
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
        	  <td height="40" align="right"></td>
        	  <td colspan="2">
		<div class="formSubBtn" style="float:left; margin-bottom:30px;">
    <input type="submit" class="submit" value="保存" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="add" />
  </div></td>
       	  </tr>
  </table>

</form>
</body>
</html>
