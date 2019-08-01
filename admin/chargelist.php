<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>充值记录</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<script>
 function chargeorder(chargeorder,types){

	   layer.open({
		   type:2,
		   title:'',
		   maxmin:true,
		   shadeClose:true,
		   area : ['480px' , '380px'],
           content: 'chargeorder.php?types='+types+'&chargeorder='+chargeorder,
	   });

   }
</script>
<?php
//初始化参数
$check = isset($check) ? $check : '';
?>
</head>
<body>
<div class="topToolbar">
<span class="title">充值记录</span>
<a href="javascript:location.reload();" class="reload">刷新</a>
</div>
<form name="form" id="form" method="post" action="money_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td width="2%" height="36" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="9%">会员账号</td>
			<td width="8%">会员UID</td>
			<td width="8%">用户昵称</td>
			<td width="10%">充值类型</td>
			<td width="12%">充值金额</td>
			<td width="8%">充值赠送</td>
			<td width="14%" align="center">充值订单号</td>
			<td width="10%" align="center">账户余额</td>
			<td width="12%" align="center">充值时间</td>
			<td colspan="2" align="center">操作</td>
		</tr>
		<?php

    if($check=="todaychongzhi"){
    $todaytime=date("Y-m-d");
    $dopage->GetPage("SELECT a.telephone,a.money,a.nickname,a.ucode,b.chargenumber,b.chargegive,b.chargetime,b.chargetype,b.chargeorder,b.id FROM `pmw_members` a inner join `pmw_charge` b on a.id=b.mid and  b.charge_ymd='$todaytime'",15);
    }elseif($check=="tomorrowchongzhi"){
    $tomorrowtime=date("Y-m-d",strtotime("-1 days"));
    $dopage->GetPage("SELECT a.telephone,a.money,a.nickname,a.ucode,b.chargenumber,b.chargegive,b.chargetime,b.chargetype,b.chargeorder,b.id FROM `pmw_members` a inner join `pmw_charge` b on a.id=b.mid and  b.charge_ymd='$tomorrowtime'",15);
    }else{
		$dopage->GetPage("SELECT a.telephone,a.money,a.nickname,a.ucode,b.chargenumber,b.chargegive,b.chargetime,b.chargetype,b.chargeorder,b.id FROM `pmw_members` a inner join `pmw_charge` b on a.id=b.mid",15);
    }
		while($row = $dosql->GetArray())
		{
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
					$chargetype = "银联卡充值";
					break;
				case 4:
					$chargetype = "云闪付充值";
					break;
				}
		?>
		<tr align="center" class="dataTr">
			<td height="36" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php  echo $row['telephone']; ?></td>
			<td><?php  echo $row['ucode'];?></td>
			<td><?php  echo $row['nickname']; ?></td>
			<td><?php  echo $chargetype; ?></td>
			<td class="num" style="color:#00b7ff"><?php  echo $row['chargenumber']; ?></td>
			<td><?php  echo $row['chargegive']; ?></td>
			<td align="center"><?php  echo $row['chargeorder']; ?></td>
			<td class="num" align="center"><?php echo sprintf("%.2f",$row['money']); ?></td>
			<td align="center"><?php  echo $row['chargetime']; ?></td><td width="1%"><span >
			<td width="3%" align="center"><div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a style="cursor:pointer" onclick="chargeorder('<?php echo $row['chargeorder']; ?>','recharge')" title="查看充值详情"><i class="fa fa-eye" aria-hidden="true"></i></a></div></td>
			<td width="3%" align="center"><div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a title="删除充值订单" href="money_save.php?id=<?php echo $row['id']; ?>&action=del6" onclick="return ConfDel(0);"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a></div></td>
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
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('money_save.php');" onclick="return ConfDelAll(0);">删除</a></span> </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<p>&nbsp;</p>

</body>
</html>
