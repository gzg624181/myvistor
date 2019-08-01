<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看下票人信息</title>
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
</head>
<script>
function closes(){
	
  var index=parent.layer.getFrameIndex(window.name);

parent.layer.close(index);
}

function gettalamount(){
	
	var infactnums=$("#infactnums").val();
	
	var nums=$("#nums").val();
	
	if(infactnums <= nums){
	
	var price = $("#price").val();
	
	var infacttotalamount =infactnums * price;
	
	$("#infacttotalamount").attr("value",infacttotalamount);
	
	}else{
		
	layer.alert("实际取票数量不能大于购票数量",{icon:0});
		
		}
	
	}

</script>
<body>
<?php
//初始化参数
$adminlevel=$_SESSION['adminlevel'];
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title" style="text-align:center;">取票实际数量</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<?php
$r=$dosql->GetOne("SELECT * FROM pmw_order where id=$id");
?>
<form name="form" id="form" method="post" action="allorder_save.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td width="22%" height="40" align="right">实际取票数量：</td>
		  <td width="78%"><input type="text" name="infactnums" id="infactnums" placeholder="实际取票数量最大不能超过<?php echo $r['nums'];?>" class="input" required="required" onblur="gettalamount();"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">票务价格：</td>
		  <td><input type="text" name="price" id="price" value="<?php echo $r['price'];?>" required="required"   class="input"/></td>
    </tr>
		<tr>
		  <td height="40" align="right">实际支付总金额：</td>
		  <td><input type="text" name="infacttotalamount" id="infacttotalamount" class="input" required="required" value=""/></td>
    </tr>
      <tr>
		  <td height="40" align="right">&nbsp;</td>
		  <td><div class="formSubBtn" style="float:left; margin-left:1px;margin-top: 15px;">
            <input type="submit" class="submit" value="提交"/>
    		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
            <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
            <input type="hidden" name="nums" id="nums" value="<?php echo $r['nums'];?>" />
            <input type="hidden" name="action" id="action" value="changenums" />
  </div></td>
    </tr>
  </table>
  </form>
</body>
</html>
