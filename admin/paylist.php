<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员充值记录</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/listajax.js"></script>
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

	<div class="topToolbar"> <span class="title">会员UID：</span><span class="num" style="color:red;"><?php echo $uid;?></span> <a title="刷新" href="javascript:location.reload();" class="reload"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<form name="form" id="form" method="post" action="product_save.php">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="center" class="head">
			<td width="11%" height="36" align="center">会员账号</td>
			<td width="17%" align="left">昵称</td>
			<td width="20%" align="center">充值类型</td>
			<td width="15%" align="center">充值金额</td>
			<td width="18%" align="center">充值赠送</td>
		  <td width="19%" align="center">购买时间</td>
		</tr>
		<?php
		$jiuqian_la=0;
		$dopage->GetPage("SELECT * FROM `pmw_charge` where mid=$id",10);
		while($row = $dosql->GetArray())
		{
		$numss[]=$row['chargenumber'];
		switch($row['chargetype'])
		{
			case 0:
				$chargetype = "后台充值";
				break;
			case 1:
				$chargetype = "支付宝充值";
				break;
			case 2:
				$chargetype = "微信充值";
					break;
			case 3:
				$chargetype = "银联充值";
					break;
			case 4:
				$chargetype = "云闪付充值";
							break;
		}
		?>
		<tr align="left" class="dataTr">
			<td height="70" align="center"><?php echo $row['chargetelephone']; ?></td>
			<td align="center"><?php echo $nickname; ?></td>
			<td align="center"><?php echo $chargetype; ?></td>
			<td align="center"><?php echo sprintf("%.2f",$row['chargenumber']); ?></td>
			<td align="center" class="num"><?php echo $row['chargegive']; ?></td>
			<td align="center"><span class="number"><?php echo $row['chargetime']; ?></span>
            </td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<?php
if($dosql->GetTotalRow() != 0){ ?>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php }?>
<?php

//判断无记录样式
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar">
<span style="text-align:right; display:block">
充值合计：<a class="num" style="color:red;">
<?php
if($dosql->GetTotalRow() == 0){
	echo 0;
	}else{
foreach($numss as $val){
	$jiuqian_la += $val;
}
echo $jiuqian_la;
	}
	?>
</a>元
</span>
</div>

</body>
</html>
