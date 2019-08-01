<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改票务价格</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script>

function closes(){

var index=parent.layer.getFrameIndex(window.name);

parent.layer.close(index);
}

function check_specs(){

   if($("#selectdate").val()==0){

	    layer.alert("请选择修改的日期！",{icon:0});

		$("#selectdate").focus();

		return false;

	   }

}

function TypeChange(){
	var options=$("#selectdate option:selected");

   var objvalue =options.val();

   if(objvalue== 0){
		 layer.alert("请选择修改的日期!",{icon:0});
	 }else{
  var id=$("#id").val();
	var ajax_url = "ticket_save.php?selectdate=" + objvalue+ "&action=searchdate"+"&id="+id;
  //alert(ajax_url);
	$.ajax({
   url:ajax_url,
  type:'get',
	data: "data" ,
	dataType:'html',
    success:function(data){
      var price = document.getElementById("price");
      price.style.display = "";
      // alert(data);
			document.getElementById("prices").value=data;
    } ,
	error:function(){
       alert('error');
    }
	 });
     }
	}
</script>
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
</style>
</head>
<body>
<?php
//初始化参数
$adminlevel=$_SESSION['adminlevel'];
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title" style="text-align:center;">修改票务价格</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><?php echo $cfg_reload;?></a></div>
<form name="form" id="form" method="post" action="ticket_save.php" onsubmit="return check_specs();">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
		<tr>
		  <td width="17%" height="40" align="center">景区名称</td>
		  <td width="20%" align="center">票务规格</td>
		  <td width="23%" align="center">票务日期</td>
		  <td width="19%" align="center">票务价格</td>
		  <td width="21%" align="center">操作</td>
    </tr>
<?php
   $month=date("m");
   $years=date("Y");
   $dosql->Execute("SELECT * FROM pmw_selectdate where sid=$sid and tid=$tid and years=$years  and (month='$month' or month='$month'+1)");
   while($row=$dosql->GetArray()){
   ?>
  
  <tr>
  <td height="40" align="center"><?php echo $names;?></td>
  <td align="center"><?php echo $tickettype;?></td>
  <td align="center"><?php echo $row['datetimes'];?></td>
  <td align="center" class="num"><?php echo $row['price'];?></td>
  <td align="center"><span><a title="编辑" href="specs_update_price.php?id=<?php echo $row['id']; ?>&names=<?php echo $names;?>&tickettype=<?php echo $tickettype;?>">
  <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span></td>
  </tr>

<?php }?>
<tr>
    <td height="40" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center" class="num">&nbsp;</td>
    <td align="center"><div class="formSubBtn" style="float:left;margin-top: 15px;margin-left: 104px;">
   <input type="button" class="back" value="返回" onclick="history.go(-1);" />  	
  </div></td>
  </tr>
  
  </table>

</form>

</body>
</html>
