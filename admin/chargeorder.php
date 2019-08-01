<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>充值成功</title>
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
    width: 280px;
    height: 35px;
    border-radius: 3px;
}
.input1 {    width: 280px;
    height: 35px;
    border-radius: 3px;
}
</style>
<script>
  function close(){
  var mylay = parent.layer.getFrameIndex(window.name);

   parent.layer.close(mylay);
}
</script>
</head>
<body>
<?php
    if($types=="recharge"){
 ?>

<div class="topToolbar"> <span class="title" style="text-align:center;">充值记录！</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<?php
$s=$dosql->GetOne("select * from `#@__charge` where chargeorder='$chargeorder'");
switch($s['chargetype'])
{
  case 0:
    $chargetype = "<i title='后台充值' style='font-size:16px;color: #3339;' class='fa fa-desktop' aria-hidden='true'></i>";
    $chargetype .="&nbsp;后台充值";
    break;
  case 1:
    $chargetype = "<i title='支付宝充值' style='font-size:16px;color: #3339;' class='fa fa-adn' aria-hidden='true'></i>";
    $chargetype .="&nbsp;支付宝充值";
    break;
  case 2:
    $chargetype = "<i title='微信充值' style='font-size:16px;color: #3339;' class='fa fa-weixin' aria-hidden='true'></i>";
    $chargetype .="&nbsp;微信充值";
    break;

  case 3:
    $chargetype = "<i title='银联充值' style='font-size:16px;color: #3339;' class='fa fa-credit-card' aria-hidden='true'></i>";
    $chargetype .="银联充值";
    break;

   case 4:
    $chargetype = "<i title='云闪付充值' style='font-size:16px;color: #3339;' class='fa fa-cc-paypal' aria-hidden='true'></i>";
    $chargetype .="云闪付充值";
    break;

}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td height="40" align="right">充值会员UID：</td>
		  <td width="78%"><?php echo $s['chargeuid'];?></td>
    </tr>
	<tr>
		  <td width="22%" height="40" align="right">充值会员账号：</td>
			<td><?php echo $s['chargetelephone'];?></td>
	</tr>
  <tr>
  <td height="40" align="right">充值方式：</td>
  <td><?php echo $chargetype;?></td>
  </tr>
		<tr>
		  <td height="40" align="right">充值金额：</td>
		  <td class="num" style="color:red;"><?php echo $s['chargenumber'];?></td>
    </tr>
    <tr>
      <td height="40" align="right">充值赠送：</td>
      <td><?php echo $s['chargegive'];?></td>
    </tr>
		<tr>
		  <td height="40" align="right">充值时间：</td>
		  <td><?php echo $s['chargetime'];?></td>
    </tr>
    <tr>
		  <td height="40" align="right">充值订单：</td>
		  <td><?php echo $s['chargeorder'];?></td>
    </tr>

  </table>
<?php }elseif($types=="take_money"){ ?>

  <div class="topToolbar"> <span class="title" style="text-align:center;">提现记录！</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
  <?php
  $s=$dosql->GetOne("select * from `#@__account` a inner join `#@__pickmoney` b on a.id=b.pick_typesid and a.mid=b.mid  where b.pick_order='$chargeorder' ");
  switch($s['type'])
  {
    case 'alipay':
      $chargetype = "<i title='支付宝提现' style='font-size:16px;color: #3339;' class='fa fa-adn' aria-hidden='true'></i>&nbsp;[支付宝提现]";
      break;
    case 'cardpay':
      $chargetype = "<i title='银行卡提现' style='font-size:16px;color: #3339;' class='fa fa-weixin' aria-hidden='true'></i>&nbsp;[银行卡提现]";
        break;
  }
  switch($s['pick_statues'])
  {
    case 0:
    $pick_statues="未发放";
    break;
    case 1:
    $pick_statues="已发放";
    break;
  }
  ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
     <tr>
       <td height="40" align="right">会员UID：</td>
       <td width="78%"><?php echo $s['pick_uid'];?></td>
      </tr>
   <tr>
       <td width="22%" height="40" align="right">提现账号：</td>
       <td><?php echo $s['pick_telephone'];?></td>
   </tr>
    <tr>
    <td height="40" align="right">提现方式：</td>
    <td><?php echo $chargetype;?></td>
    </tr>
     <tr>
       <td height="40" align="right">提现金额：</td>
       <td class="num" style="color:red;"><?php echo $s['pick_number'];?></td>
      </tr>
      <tr>
        <td height="40" align="right">提现账号：</td>
        <td><?php echo $s['account'];?></td>
       </tr>
       <?php if($s['type']=="cardpay"){ ?>
         <tr>
           <td height="40" align="right">银行名称：</td>
           <td><?php echo $s['bankname'].$s['lastbankname'];?></td>
          </tr>
       <?php } ?>
     <tr>
       <td height="40" align="right">提现时间：</td>
       <td><?php echo date("Y-m-d H:i:s",$s['pick_time']);?></td>
      </tr>
      <tr>
       <td height="40" align="right">提现订单：</td>
       <td><?php echo $s['pick_order'];?></td>
      </tr>
      <tr>
       <td height="40" align="right">是否发放：</td>
       <td><?php echo $pick_statues;?></td>
      </tr>

    </table>

<?php } ?>
</body>
</html>
