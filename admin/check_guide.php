<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看接单的导游信息</title>
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
    width: 325px;
    height: 35px;
    border-radius: 3px;
}
.input1 {    width: 280px;
    height: 35px;
    border-radius: 3px;
}
.input2 {    width: 325px;
    height: 35px;
    border-radius: 3px;
}
</style>
<script>
function close_guide(){
var index = parent.layer.getFrameIndex(window.name);
parent.layer.close(index);//关闭当前页
	}

</script>
</head>
<body>
<?php
//初始化参数
$adminlevel=$_SESSION['adminlevel'];
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title" style="text-align:center;">查看接单的导游信息</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<?php
$action="travel_save.php";
$r=$dosql->GetOne("SELECT * from pmw_guide where id=$id");
switch($r['sex']){
	case 0:
	$sex="女";
	break;
	case 1:
	$sex="男";
	break;
	}
            if($r['images']==""){
			$images="../templates/default/images/noimage.jpg";
		    }else{
            $images=$r['images'];
            }
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td height="111" align="right">导游头像：</td>
		  <td><div id="layer-photos-demo_<?php  echo $row['id'];?>" class="layer-photos-demo"> <img  width="100px;" layer-src="<?php echo $images;?>" style="cursor:pointer" onclick="message('<?php echo $r['id']; ?>');"  src="<?php echo $images;?>" alt="<?php echo $r['name']; ?>" /></div></td>
  </tr>
		<tr>
		  <td width="22%" height="40" align="right">导游账号：</td>
		  <td><?php echo $r['account'];?></td>
    </tr>

		<tr>
		  <td height="40" align="right">导游姓名：</td>
		  <td><?php echo $r['name'];?></td>
    </tr>
    <tr>
		  <td height="40" align="right">性别：</td>
		  <td width="78%"><?php echo $sex;?></td>
    </tr>
		<tr>
		  <td height="40" align="right">导游证号：</td>
		  <td><?php echo $r['cardnumber'];?></td>
        </tr>
		<tr>
		  <td height="40" align="right">导游证件：</td>
		  <td><img src="<?php echo $r['card'];?>" width="300"  /></td>
        </tr>
        <tr>
		  <td height="40" align="right">导游电话：</td>
		  <td><?php echo $r['tel'];?></td>
        </tr>

		<tr>
		  <td height="40" align="right">导游简介：</td>
		  <td><?php echo $r['content'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">注册时间：</td>
		  <td><?php echo date("Y-m-d H:i:s",$r['regtime']);?></td>
    </tr>
      <tr>
		  <td height="40" align="right">&nbsp;</td>
		  <td><div class="formSubBtn" style="float:left; margin-left:1px;margin-top: 15px;">
            <input type="button" class="submit" value="关闭" onclick="close_guide()" />
  </div></td>
    </tr>
</table>
	
</body>
</html>
