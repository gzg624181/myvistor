<?php
header("Content-Type: text/html; charset=utf-8");
require_once("../../include/config.inc.php");
include 'WeixinPay.php';
$appid= $cfg_appid;       //小程序端传递过来的 appid
$openid= $openid;
$mch_id= $cfg_mchid; //微信支付商户支付号
$key= $cfg_key; //Api 密钥

$out_trade_no = date('YmdHis').rand(111111,999999);
$total_fee = $cfg_vip;  //小程序端传递过来的金额
$body = "开通会员VIP";
$total_fee = floatval($total_fee * 100);

$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee);
$return=$weixinpay->pay();

?>
