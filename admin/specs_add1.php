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
<div class="topToolbar"> <span class="title" style="text-align:center;">添加票务规格</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><?php echo $cfg_reload;?></a></div>
<?php
$s=$dosql->GetOne("SELECT * from `#@__ticket` where id=$id");
?>
<form name="form" id="form" method="post" action="ticket_save.php" onsubmit="return check_specs();">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
		<tr>
		  <td width="19%" height="40" align="right">票务类型</td>
		  <td width="25%" align="center">最低价格</td>
		  <td width="25%" align="center">正常价格</td>
		  <td width="31%">操作</td>
    </tr>
<?php
   $dosql->Execute("SELECT * FROM pmw_specs where tid=$id");
   while($row=$dosql->GetArray()){
?>
  <tr>
  <td height="40" align="right"><?php echo $row['tickettype'];?></td>
  <td align="center"><?php echo $row['normalmoney'];?></td>
  <td align="center"><?php echo $row['resetmoney'];?></td>
  <td><span><a title="编辑" href="specs_update.php?id=<?php echo $row['id']; ?>">
  <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span> &nbsp;&nbsp;
  <span class="nb"><a title="删除" href="ticket_save.php?action=del100&id=<?php echo $row['id']; ?>&tid=<?php echo $row['tid'];?>" onclick="return ConfDel(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span></td>
  </tr>
<?php }?>
  </table>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

		<tr>
		  <td height="40" align="right">景区名称：</td>
		  <td width="78%"><input style="width:494px" type="text" name="names" id="names" class="input" readonly="readonly" value="<?php echo $s['names'];?>"/></td>
    </tr>

  <tr>
  <td height="40" align="right">票务类型：</td>
  <td><input type="text" style="width:494px;" name="tickettype" id="tickettype" placeholder="请输入票务类型" value="" required="required" class="input"/></td>
  </tr>
      <tr>
		  <td height="40" align="right">请选择修改的日期：</td>
		  <td>
          <div id="select_box">
	    <select  id="selectdate" name="selectdate"  class="input" style="border-radius:3px; height:35px; width:505px;" onchange="TypeChange();">
	        <option value="0">请选择修改日期</option>
            <?php
			$year=date("Y");
			$month=date("m");
			$days=getMonthLastDay($month,$year);
			for($i=1;$i<=$days;$i++){
			?>
	        <option value="<?php echo strtotime(date("Y-m-").str_pad($i,2,"0",STR_PAD_LEFT));?>"><?php echo date("Y-m-").str_pad($i,2,"0",STR_PAD_LEFT);?></option>
            <?php }?>

	    </select>
			<span class="maroon">*</span>
	</div>
          </td>
      </tr>
          <tr id="price"  style="display:none;">
          <td height="40" align="right">票务价格：</td>
          <td><input type="text" style="width:494px;" name="prices" id="prices" placeholder="请输入票务价格" value="" required="required" class="input"/></td>
          </tr>
 <tr>
  <td height="40" align="right"></td>
  <td><div class="formSubBtn" style="float:left;margin-top: 15px;">
       <input type="submit" class="submit" value="提交" />
    	 <input type="button" class="back" value="返回" onclick="history.go(-1);" />
    	 <input type="hidden" name="action" id="action" value="specs_add" />
       <input type="hidden" name="tid" id="tid" value="<?php echo $id;?>" />
       <input type="hidden" name="lowmoney" id="lowmoney" value="<?php echo $lowmoney;?>" />
  </div></td>
  </tr>
  <tr>
  <td height="40" align="right"></td>
  <td></td>
  </tr>
  </table>

</form>

</body>
</html>
