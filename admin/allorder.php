<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>购票记录</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<style>
.layui-layer-iframe .layui-layer-btn, .layui-layer-page .layui-layer-btn {
    padding-top: 10px;
    text-align: center;
}
</style>
<script>
function getticket(id,type){
layer.open({
  type: 2,
  title: '下票人详细信息：',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['600px' , '345px'],
  content: 'changeticket.php?id='+id+'&type='+type,
  });
  }

function changenums(id){
layer.open({
  type: 2,
  title: '实际取票数量：',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['600px' , '305px'],
  content: 'changenums.php?id='+id,
  });
  }
   //审核，未审，功能
function checkinfo(key){
var v= key;
window.location.href='allorder.php?check='+v;
   	}
  function GetSearchs(){
var keyword= document.getElementById("keyword").value;
if($("#keyword").val() == "")
{
 layer.alert("请输入搜索内容！",{icon:0});
 $("#keyword").focus();
 return false;
}
window.location.href='allorder.php?keyword='+keyword;
}
</script>
<?php
//初始化参数
$tbname="pmw_order";
$check = isset($check) ? $check : '';
$keyword = isset($keyword) ? $keyword : '';
$adminlevel=$_SESSION['adminlevel'];
?>
</head>
<body>
<div class="topToolbar">
<span class="title">订单记录</span>
<a href="javascript:location.reload();" class="reload"><?php echo $cfg_reload;?></a>
</div>
<div class="toolbarTab">
	<ul>
 <li class="<?php if($check==""){echo "on";}?>"><a href="allorder.php">全部</a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="onrent"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('onrent')">已支付&nbsp;&nbsp;<i class='fa  fa-check' aria-hidden='true' style="color:#30B534"></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="unrent"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('unrent')">未支付&nbsp;&nbsp;<i class='fa fa-times' aria-hidden='true' style="color:red"></i></a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="wxpay"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('wxpay')">微信支付&nbsp;&nbsp;<i class='fa fa-weixin' aria-hidden='true' style="color:#7bcb2b"></i></a></li>
  </ul>
  <div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" placeholder="请输入订单号码，用户昵称进行搜索" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>
<form name="form" id="form" method="post" action="allorder_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td width="1%" height="36" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="6%">下单人头像</td>
			<td width="7%">下单人昵称</td>
			<td width="7%">下单人性别</td>
			<td width="16%">支付订单号</td>
			<td width="13%">支付金额</td>
			<td width="9%">支付方式</td>
			<td width="15%">下单时间</td>
			<td width="7%" align="center">下单设备</td>
			<td width="8%" align="center">支付状态</td>
			<td width="11%" align="center">操作</td>
		</tr>
		<?php

  if($check=="onrent"){ //已支付
   $dopage->GetPage("SELECT a.*,b.nickname,b.images,b.sex from pmw_order a inner join pmw_members b on a.pay_openid=b.openid and a.pay_state=1",10,"DESC","b.pay_time");
 }elseif($check=="confirm"){ //未支付
   $dopage->GetPage("SELECT a.*,b.nickname,b.images,b.sex from pmw_order a inner join pmw_members b on a.pay_openid=b.openid and a.pay_state=0",10,"DESC","b.pay_time");
 }elseif($check=="wxpay"){ //微信支付
  $dopage->GetPage("SELECT a.*,b.nickname,b.images,b.sex from pmw_order a inner join pmw_members b on a.pay_openid=b.openid",10,"DESC","b.pay_time");
 }elseif($check=="today"){
   $ymd=date("Y-m-d");
   $dopage->GetPage("SELECT * FROM $tbname where ymd='$ymd'",10);
 }elseif($check=="tomorrowdingdan"){
   $ymd=date("Y-m-d",strtotime("-1 day"));
   $dopage->GetPage("SELECT * FROM $tbname where ymd='$ymd'",10);
  }elseif($check=="today_zhiufu"){
   $ymd=date("Y-m-d");
   $dopage->GetPage("SELECT * FROM $tbname where ymd='$ymd'",10);
 }elseif($check=="tomorrow_zhifu"){
   $ymd=date("Y-m-d",strtotime("-1 day"));
   $dopage->GetPage("SELECT * FROM $tbname where ymd='$ymd'",10);
 }elseif($keyword!=""){
   $dopage->GetPage("SELECT * FROM $tbname where jingquname like '%$keyword%' OR contactname like '%$keyword%' OR contacttel like '%$keyword%'  OR usetime like '%$keyword%' ",10);
}else{
   $dopage->GetPage("SELECT a.*,b.nickname,b.images,b.sex from pmw_order a inner join pmw_members b on a.pay_openid=b.openid",10,"DESC","b.pay_time");
     }
		while($row = $dosql->GetArray())
		{
			switch($row['pay_state'])
			{

				    case 1:
					$states = "<font color='#339933'><B>"."<i title='已支付' class='fa fa-check' aria-hidden='true'></i>"."</b></font>";
					break;
				    case 0:
					$states = "<font color='#FF0000'><B>"."<i title='待支付' class='fa fa-times' aria-hidden='true'></i>"."</b></font>";
					break;
				}

				switch($row['sex'])
			{
				case 1:
					$sex = "<i title='男' style='font-size:16px;color: blue; font-weight:bold;' class='fa fa-venus' aria-hidden='true'></i>";
					break;
				case 0:
					$sex = "<i title='女' style='font-size:16px;color: red;font-weight:bold;' class='fa fa-mercury' aria-hidden='true'></i>";
					break;

			}
			
			switch($row['device'])
			{
				case 1:
					$device = "<i title='苹果'  class='fa fa-apple' aria-hidden='true'></i>";
					break;
				case 0:
					$device = "<i title='安卓' class='fa fa-android' aria-hidden='true'></i>";
					break;
				default:
				    $device = "<i title='PC' class='fa fa-desktop' aria-hidden='true'></i>";
					break; 

			}
		?>
		<tr align="center" class="dataTr">
			<td height="40" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><Img src="<?php echo $row['images'];?>" style="width:80px;border-radius:6px; padding:3px;"  /></td>
			<td><?php echo $row['nickname'];?></td>
			<td><?php echo $sex;?></td>
			<td><?php echo $row['orderid'];?></td>
			<td class="num"><?php echo $row['paymoney'];?></td>
			<td class="num" style="color:#7bcb2b">微信支付</td>
			<td><?php echo date("Y-m-d H:i:s",$row['pay_time']);?></td>
			<td align="center"><?php echo $device; ?></td>
			<td align="center"><?php echo $states; ?></td>
			<td>
			  <?php if($adminlevel==1){ ?>
			  <a title="删除购票订单" href="allorder_save.php?id=<?php echo $row['id']; ?>&amp;action=del6" onclick="return ConfDel(0);"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>
			  <?php }else{?>
			  <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
			  <?php } ?>
		  </td>
	    </tr>
		<?php
		}
		?>
	</table>
</form>
<?php

//判断无记录样式
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<p>&nbsp;</p>

</body>
</html>
