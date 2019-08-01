<?php
    /**
	   * 链接地址：add_order  添加订单
	   *
     * 下面直接来连接操作数据库进而得到json串
     *
     * 按json方式输出通信数据
     *
     * @param unknown $State 状态码
     *
     * @param string $Descriptor  提示信息
     *
	   * @param string $Version  操作时间
     *
     * @param array $Data 数据
     *
     * @return string
     *
     * @购票订单   提供返回参数账号，
     * tid               票务id
     * jingquname        景区名称
     * type              下票单位（目前可能是导游或者旅行社）
     * did               下单人id
     * contactname       联系人姓名
     * contacttel        联系人电话
     * usetime           使用日期（varchar）
     * price             单张票的价格
     * typename          票务类型（成人票，儿童票，优惠票）
     * nums              票务数量
     * totalamount       支付总金额
     * paytype           支付类型（线下支付，微信支付）
     * orderid           支付订单号
     * states            后台票务处理状态（默认未处理0，已处理1）
     * posttime           添加时间
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：添加行程的时候content 内容以json字符串的形式保存在数据库中去

  $posttime=time();  //添加时间

  $orderid =date('YmdHis').rand(11111111,99999999);

  $ymd=date("Y-m-d");

  $timestampuse= strtotime($usetime);

  //将用户的formid添加进去
  add_formid($openid,$formid);

  $sql = "INSERT INTO `#@__order` (tid,jingquname,type,did,contactname,contacttel,usetime,price,typename,nums, totalamount,paytype,orderid,posttime,timestampuse,ymd) VALUES ($tid,'$jingquname','$type',$did,'$contactname','$contacttel','$usetime','$price','$typename',$nums,'$totalamount','$paytype','$orderid',$posttime,$timestampuse,'$ymd')";
  $dosql->ExecNoneQuery($sql);

  //下单成功之后发送双向消息
  #给购票的用户发送模板消息

  // $information= get_information($did,$type);
  // $openid=$information['openid'];
  $form_id=get_new_formid($openid);
  $id=get_orderid($did,$posttime);
  $page="pages/booking/bookingDetail/bookingDetail?id=".$id."&tem=tem";
  $posttime=date("Y-m-d H:i:s"); //购票时间
  $tishi="亲爱的".$contactname."您好，您的购票订单已提交成功，可点击进入小程序查看购票详情";

  paysuccess($openid,$cfg_paysuccess,$page,$form_id,$jingquname,$typename,$nums,$totalamount,$posttime,$tishi,$cfg_appid,$cfg_appsecret);

  //删除已经用过的formid
  del_formid($form_id,$openid);

  #向下票人发送购票成功订单的模板消息
  $page="pages/index/index?tem=tem";
  switch($type){

    case "agency":
    $type="旅行社";
    break;

    case "guide":
    $type="导游";
    break;
  }

  switch($paytype){

    case "wxpay":
    $paytype="微信支付";
    break;

    case "outline":
    $paytype="线下支付";
    break;

  }
  $array_admin=get_openid_formid();
  $openid=$array_admin['openid'];
  $form_id=get_new_formid($openid);

  ticketsuccess($openid,$cfg_ticketsuccess,$page,$form_id,$jingquname,$typename,$usetime,$nums,$type,$totalamount,$contactname,$contacttel,$paytype,$posttime,$cfg_appid,$cfg_appsecret);

  //删除已经用过的formid
  del_formid($form_id,$openid);

  $State = 1;
  $Descriptor = '订单下注成功！!';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $Data
               );
  echo phpver($result);

}else{
  $State = 520;
  $Descriptor = 'token验证失败！';
  $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
  				         'Version' => $Version,
                   'Data' => $Data,
                   );
  echo phpver($result);
}

?>
