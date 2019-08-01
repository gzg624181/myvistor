<?php

$postXml = $GLOBALS["HTTP_RAW_POST_DATA"]; //接收微信参数
// 接受不到参数可以使用 file_get_contents("php://input"); PHP 高版本中$GLOBALS 好像已经被废弃了
if (empty($postXml)) {
    return false;
}

//将 xml 格式转换成数组
function xmlToArray($xml) {
    //禁止引用外部 xml 实体
    libxml_disable_entity_loader(true);
    $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    $val = json_decode(json_encode($xmlstring), true);
    return $val;
}

function write_log($data)
{
  //设置支付的log日志
  $yeartime = date("Ymd");
  $listtime = date("YmdHis");
  //设置目录信息
  $url = './log/'.$yeartime.'/'.$listtime.".txt";
  $dir_name = dirname($url);
  //目录不存在就创建
  if(!file_exists($idr_name)){
    //iconv防止中文乱码
    $res = mkdir(iconv("UTF-8","GBK",$dir_name),0777,true);
  }
  $results = print_r($data, true);
  file_put_contents($url, $results);
}
$attr = xmlToArray($postXml);
write_log($attr);
// $total_fee = $attr['total_fee'];   //微信支付的金额
// $open_id = $attr['openid'];        //用户的openid
// $out_trade_no = $attr['out_trade_no'];  //支付的订单号
// $time = $attr['time_end']; //交易截止时间

if(array_key_exists("return_code", $attr)
  && array_key_exists("result_code", $attr)
  && $attr["return_code"] == "SUCCESS"
  && $attr["result_code"] == "SUCCESS")
{
 $orderid = $attr['out_trade_no'];
 $openid = $attr['openid'];

 $mysql_server_name="localhost"; //数据库服务器名称
 $mysql_username="jiante_yishekj_"; // 连接数据库用户名
 $mysql_password="waGXBDQKTZHxMpR8"; // 连接数据库密码
 $mysql_database="jiante_yishekj_"; // 数据库的名字

 // 连接到数据库，将订单的状态改为已付款
 $conn=mysql_connect($mysql_server_name, $mysql_username,$mysql_password);

 $strsql="UPDATE `pmw_order` SET pay_state=1 WHERE orderid='$orderid'";
 mysql_db_query($mysql_database, $strsql, $conn);

 // 将用户更改为vip
 $strsql2="UPDATE `pmw_members` SET vip=1 WHERE openid='$openid'";
 mysql_db_query($mysql_database, $strsql2, $conn);
 //海报poster_id

 $sql="SELECT pid from pmw_order where orderid='$orderid'";
 $r=mysql_fetch_assoc(mysql_db_query($mysql_database,$sql,$conn));
 $poster_id=$r['pid'];

 //如果是普通会员则在支付成功的时候，则将是否查看更改为1

 //更改还未查看的访客记录
 $strsql1="UPDATE `pmw_record` SET islook=1 WHERE poster_id=$poster_id";
  mysql_db_query($mysql_database, $strsql1, $conn);
}
 ?>
