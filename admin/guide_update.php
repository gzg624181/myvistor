<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改会员</title>
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
<script type="text/javascript" src="templates/js/ajax.js"></script>
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
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__guide` WHERE id=$id");
if(check_str($row['images'], "https")){
  $images= $row['images'];
}else{
  $images=  $cfg_weburl."/".$row['images'];
}
$adminlevel=$_SESSION['adminlevel'];
?>
<div class="formHeader"> <span class="title">修改导游信息</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="guide_save.php" onsubmit="return cfm_up();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
			<td width="25%" height="45" align="right">账　号：</td>
			<td width="75%"><strong><?php echo $row['account']; ?></strong></td>
		</tr>
		<tr>
			<td height="45" align="right"> 姓　名：</td>
			<td><input name="name" type="text" class="input" id="name" value="<?php echo $row['name']; ?>"  required="required" /></td>
		</tr>
		<tr>
		  <td height="45" align="right">性　别：</td>
			<td><input type="radio" name="sex" value="1" <?php if($row['sex'] == 1) echo 'checked="checked"'; ?> />
				男&nbsp;
			  <input type="radio" name="sex" value="0" <?php if($row['sex'] == 0) echo 'checked="checked"'; ?> />
				女</td>
	  </tr>
		<tr>
		  <td height="155" align="right">导游证件：</td>
		  	<td colspan="11" valign="middle">
             <div id="layer-photos-demo_<?php  echo $row['id'];?>" class="layer-photos-demo"> <img  width="100px;" layer-src="<?php echo $cfg_weburl."/".$row['card'];?>" style="cursor:pointer; padding:8px;" onclick="message('<?php echo $row['id']; ?>');"
              src="<?php echo $cfg_weburl."/".$row['card'];?>" alt="<?php echo $row['name']; ?>" /></div><br />
            <input style="margin-top:5px;" type="text" name="card" id="card" class="input" value="<?php echo $row['card'];?>"  required="required"/>
				<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,20971520,'card')">上 传</span> </span></td>
	  </tr>
		<tr>
			<td height="45" align="right">导游证号：</td>
			<td><input type="text" name="cardnumber" id="cardnumber" class="input" value="<?php echo $row['cardnumber']; ?>" /></td>
		</tr>
        <tr>
		  <td height="155" align="right">合同：</td>
		  	<td colspan="11" valign="middle">
           <fieldset class="picarr">
					<legend>列表</legend>
					<div>最多可以上传<strong>50</strong>张图片<span onclick="GetUploadify('uploadify2','组图上传','image','image',50,<?php echo $cfg_max_file_size; ?>,'picarr','picarr')">开始上传</span></div>
					<ul id="picarr">
						<?php

					if($row['agreement'] != '')
					{
						$picarr = json_decode($row['agreement']);
						foreach($picarr as $v)
						{
							$v = explode(',', $v);
							echo '<li rel="'.$v[0].'"><input type="hidden" name="picarr[]" value="'.$v[0].'"><img src="'.$cfg_weburl."/".$v[0].'" width="100" height="120" ><a href="javascript:void(0);" onclick="ClearPicArr(\''.$v[0].'\')">删除</a></li>';
						}
					}
					?>
					</ul>

				</fieldset>（长宽比例 2：1）</td>
	  </tr>
		<tr>
			<td height="45" align="right">导游电话：</td>
			<td><?php echo $row['tel']; ?></td>
		</tr>
        <tr>
			<td height="45" align="right">密　码：</td>
			<td><input type="text"  name="password" id="password" class="input"  placeholder="如果密码不修改，则默认为空" /></td>
		</tr>
        <tr>
			<td height="118" align="right">简　介：</td>
			<td><textarea name="content" id="content" class="textarea"><?php echo $row['content']; ?></textarea></td>
		</tr>
		<tr>
			<td height="163" align="right">头　像：</td>
			<td colspan="11" valign="middle">
            <img  width="100px;" src="<?php echo $images;?>" alt="<?php echo $row['name']; ?>" /><br />
   <input style="margin-top:5px;" type="text" name="images" id="images" class="input" value="<?php echo $row['images'];?>"  required="required"/>
				<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,20971520,'images')">上 传</span> </span></td>

          </td>
		</tr>
		<tr>
			<td height="45" align="right">注册时间：</td>
			<td><input type="text" name="regtime" id="regtime" class="input"  value="<?php echo date("Y-m-d H:i:s",$row['regtime']); ?>"  /></td>
		</tr>
        <?php
		if($adminlevel==1){
		?>
        <?php }?>
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
  </div>
</form>
</body>
</html>
