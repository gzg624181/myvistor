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
<div class="topToolbar"> <span class="title" style="text-align:center;">充值成功！</span> <a title="刷新" href="javascript:location.reload();" class="reload" style="float:right; margin-right:35px;"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<?php
$s=$dosql->GetOne("select * from `#@__charge` where randnumber=$randnumber");
switch($s['chargetype'])
{
  case 0:
    $chargetype = "<i title='后台充值' style='font-size:16px;color: #3339;' class='fa fa-desktop' aria-hidden='true'></i>";
    break;
  case 1:
    $chargetype = "<i title='支付宝充值' style='font-size:16px;color: #3339;' class='fa fa-adn' aria-hidden='true'></i>";
    break;
  case 2:
    $chargetype = "<i title='微信充值' style='font-size:16px;color: #3339;' class='fa fa-weixin' aria-hidden='true'></i>";
      break;
  case 3:
    $chargetype = "<i title='银联充值' style='font-size:16px;color: #3339;' class='fa fa-credit-card' aria-hidden='true'></i>";
      break;
  case 4:
    $chargetype = "<i title='充值' style='font-size:16px;color: #3339;' class='fa fa-cc-paypal' aria-hidden='true'></i>";
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

  </table>

</body>
</html>
