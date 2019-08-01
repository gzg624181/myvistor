<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('weblink'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发送模板消息</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<script>
function sendmessage(){
	//验证友情链接
		if(window.confirm('确定要发送模板消息吗?')){

			if($("#type").val() ==  0)
		 {
			 layer.alert("请选择发送模板消息的类型!",{icon:0});
			 $("#type").focus();
			 return false;
		 }
		 if($("#linkurl").val() == 0)
		 {
			 layer.alert("请选择跳转链接！",{icon:0});
			 $("#linkurl").focus();
			 return false;
		 }
  var type=$('#type').val();          //消息类型
	var content=$('#content').val();    //消息内容
	var linkurl=$('#linkurl').val();    //跳转链接
	var posttime=$('#posttime').val();   //发布时间
	var ajax_url='send_save.php?type='+type+'&content='+content+'&linkurl='+linkurl+'&posttime='+posttime+'&action=add_post';
   //alert(ajax_url);
	var ii = layer.load(0,
	{
	content:'Sending……',
	offset: '300px',
	success: function(layero){
	layero.find('.layui-layer-content').css('padding-top', '23px');
	}})
	$.ajax({
    url:ajax_url,
    type:'post',
	  data: "data" ,
	  dataType:'html',
    success:function(data){
			if(data==1){
			layer.close(ii);
			alert('模板消息发送成功！');
			window.location.href="send_template_message.php";
			}
    } ,
	  error:function(){
			layer.close(ii);
			layer.msg('网络繁忙，请稍后重试...');
			return false;
    }
	});
	}
}

</script>
</head>
<body>
<div class="topToolbar">
  <span class="title">发送系统模板消息：
</span> <a href="javascript:location.reload();" class="reload"><?php echo $cfg_reload;?></a>
</div>
<form name="form" id="form" method="post" action="" >
	<table width="100%" border="0" id="go" cellspacing="0" style="display:" cellpadding="0" class="formTable">
		<tr>
			<td width="25%" height="50" align="right">消息类型：</td>
			<td width="75%">
				<div id="select_box">
	    <select  id="type" name="type"  class="input" style="border-radius:3px; height:35px; width:505px;">
	        <option value="0">请选择发送模板消息的类型</option>
	        <option value="agency">旅行社</option>
            <option value="guide">导游</option>
	    </select>
			<span class="maroon">*</span>
	</div>

			</td>
		</tr>

		<tr>
			<td height="160" align="right">消息内容：</td>
			<td><textarea style="width:500px;height: 134px;border-radius: 3px;" class="input" name="content" id="content"></textarea><span class="maroon">*</span></td>
		</tr>
		<tr>
			<td height="50" align="right">跳转链接：</td>
			<td>
             <select id="linkurl" name="linkurl" style="border-radius:3px; height:35px; width:505px;" class="input">
	        <option value="0">请选择跳转的页面</option>
	        <option value="pages/index/index">首页</option>
            <option value="pages/booking/index/index">票务</option>
	         </select></td>
		</tr>
		<tr>
			<td height="50" align="right">发布时间：</td>
			<td><input type="text" name="posttime" id="posttime" class="input" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script><span class="maroon">*</span></td>
		</tr>
	</table>
	<div id="newsives"></div>
	<div class="formSubBtn">
		<input type="button" class="submit" value="提交" onclick="sendmessage();" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="add_post" />
	</div>
</form>
</body>
</html>
